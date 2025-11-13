<?php

namespace App\Http\Requests\Order;

use App\Enum\OrderStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => ['required', 'exists:customers,id'],
            'address_id' => ['required', 'exists:addresses,id'],
            'total_price' => ['required', 'integer', 'min:0'],
            'shipping_cost' => ['nullable', 'integer', 'min:0'],
            'grand_total' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', Rule::in(OrderStatus::values())],
            'payment_method' => ['nullable', 'string', 'max:100'],
            'payment_status' => ['nullable', 'string', Rule::in(['unpaid', 'paid', 'failed'])],
            'midtrans_transaction_id' => ['nullable', 'string', 'max:255'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'exists:products,id'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
            'items.*.price' => ['required', 'integer', 'min:0'],
        ];
    }

    protected function prepareForValidation(): void
    {
        // Hitung otomatis grand_total jika belum dikirim dari form
        $total = (int) $this->input('total_price', 0);
        $shipping = (int) $this->input('shipping_cost', 0);

        if (!$this->has('grand_total')) {
            $this->merge([
                'grand_total' => $total + $shipping,
            ]);
        }
    }
}