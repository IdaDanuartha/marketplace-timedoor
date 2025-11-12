<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Enum\OrderStatus;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;
        $orders = Order::with(['items.product'])
            ->where('customer_id', $customer->id)
            ->latest()
            ->get();

        return view('shop.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // $this->authorize('view', $order);
        $order->load('items.product');
        return view('shop.orders.show', compact('order'));
    }

    public function pay(Order $order)
    {
        // $this->authorize('update', $order);

        if ($order->payment_status === 'PAID') {
            return redirect()->route('shop.orders.show', $order)->withErrors('This order has already been paid.');
        }

        $payload = [
            'transaction_details' => [
                'order_id' => $order->code,
                'gross_amount' => $order->grand_total,
            ],
            'customer_details' => [
                'first_name' => $order->customer->name,
                'email' => $order->customer->user->email,
                'phone' => $order->customer->phone,
            ],
            'enabled_payments' => ['gopay', 'bank_transfer', 'qris', 'shopeepay'],
        ];

        $snapToken = Snap::getSnapToken($payload);
        $order->update(['midtrans_transaction_id' => $snapToken]);

        return view('shop.checkout.payment', compact('order', 'snapToken'));
    }

    public function cancel(Order $order)
    {
        // $this->authorize('update', $order);

        if ($order->status !== OrderStatus::PENDING) {
            return back()->withErrors('Only pending orders can be canceled.');
        }

        $order->update([
            'status' => OrderStatus::CANCELED,
            'payment_status' => 'CANCELED',
        ]);

        return redirect()->route('shop.orders.index')->with('success', 'Order has been canceled.');
    }
}