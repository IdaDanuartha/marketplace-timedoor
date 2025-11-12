<?php

namespace App\Exports;

use App\Enum\OrderStatus;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Order::with('customer');

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['payment_status'])) {
            $query->where('payment_status', $this->filters['payment_status']);
        }

        if (!empty($this->filters['payment_method'])) {
            $query->where('payment_method', $this->filters['payment_method']);
        }

        if (!empty($this->filters['date_from']) && !empty($this->filters['date_to'])) {
            $query->whereBetween('created_at', [
                $this->filters['date_from'] . ' 00:00:00',
                $this->filters['date_to'] . ' 23:59:59',
            ]);
        }

        return $query->latest()->get();
    }

    public function headings(): array
    {
        return [
            'Order Code',
            'Customer',
            'Status',
            'Payment Method',
            'Payment Status',
            'Total Price',
            'Shipping Cost',
            'Grand Total',
            'Created At',
        ];
    }

    public function map($order): array
    {
        $statusLabel = $this->safeStatusLabel($order->status);

        return [
            $order->code,
            $order->customer?->name ?? '-',
            $statusLabel,
            strtoupper($order->payment_method ?? '-'),
            strtoupper($order->payment_status ?? '-'),
            'Rp' . number_format($order->total_price, 0, ',', '.'),
            'Rp' . number_format($order->shipping_cost, 0, ',', '.'),
            'Rp' . number_format($order->grand_total, 0, ',', '.'),
            optional($order->created_at)->format('d M Y H:i'),
        ];
    }

    private function safeStatusLabel($status): string
    {
        if ($status instanceof OrderStatus) {
            return $status->label();
        }

        if (is_string($status)) {
            $status = strtoupper($status);
            $enum = collect(OrderStatus::cases())->first(fn($c) => $c->value === $status);
            return $enum ? $enum->label() : ucfirst(strtolower($status));
        }

        return '-';
    }
}