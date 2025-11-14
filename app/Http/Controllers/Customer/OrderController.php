<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Interfaces\OrderRepositoryInterface;
use App\Models\Order;
use App\Enum\OrderStatus;
use Illuminate\Support\Facades\Auth;
use Throwable;

class OrderController extends Controller
{
    public function __construct(private readonly OrderRepositoryInterface $orderRepo) {}

    public function index()
    {
        try {
            $customer = Auth::user()->customer;
            $orders = $this->orderRepo->getCustomerOrders($customer->id);

            return view('shop.orders.index', compact('orders'));

        } catch (Throwable $e) {
            report($e);
            return back()->withErrors('Failed to load orders.');
        }
    }

    public function show($orderCode)
    {
        try {
            $customer = Auth::user()->customer;

            $order = $this->orderRepo->findByCodeForCustomer($orderCode, $customer->id);

            if (!$order) {
                return back()->withErrors('Order not found.');
            }

            return view('shop.orders.show', compact('order'));

        } catch (Throwable $e) {
            report($e);
            return back()->withErrors('Failed to load order details.');
        }
    }

    public function pay(Order $order)
    {
        try {
            if ($order->payment_status === 'PAID') {
                return redirect()->route('shop.orders.show', $order)
                    ->withErrors('This order has already been paid.');
            }

            $snapToken = $this->orderRepo->generatePayment($order);

            if (!$snapToken) {
                return back()->withErrors('Failed to generate payment token.');
            }

            return view('shop.checkout.payment', compact('order', 'snapToken'));

        } catch (Throwable $e) {
            report($e);
            return back()->withErrors('Payment process failed.');
        }
    }

    public function cancel(Order $order)
    {
        try {
            if ($order->status !== OrderStatus::PENDING) {
                return back()->withErrors('Only pending orders can be canceled.');
            }

            $this->orderRepo->cancelOrder($order);

            return back()->with('success', 'Order has been canceled.');

        } catch (Throwable $e) {
            report($e);
            return back()->withErrors('Failed to cancel order.');
        }
    }
}