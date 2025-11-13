<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\{Cart, Order, OrderItem};
use App\Enum\OrderStatus;
use App\Enum\ProductStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Exception;

class CheckoutController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;
        $cart = Cart::with('items.product')->where('customer_id', $customer->id)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('shop.cart.index')->withErrors('Your cart is empty.');
        }

        $addresses = $customer->addresses()->get();
        $subtotal = $cart->items->sum('subtotal');
        $shippingCost = 15000;
        $grandTotal = $subtotal + $shippingCost;

        return view('shop.checkout.index', compact('cart', 'addresses', 'subtotal', 'shippingCost', 'grandTotal'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
        ]);

        $customer = Auth::user()->customer;
        $cart = Cart::with('items.product')->where('customer_id', $customer->id)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return back()->withErrors('Your cart is empty.');
        }

        $subtotal = $cart->items->sum('subtotal');
        $shippingCost = 15000;
        $grandTotal = $subtotal + $shippingCost;

        DB::beginTransaction();
        try {
            // Create order with enum
            $order = Order::create([
                'code' => 'ORD-' . strtoupper(Str::random(8)),
                'customer_id' => $customer->id,
                'address_id' => $request->address_id,
                'total_price' => $subtotal,
                'shipping_cost' => $shippingCost,
                'grand_total' => $grandTotal,
                'status' => OrderStatus::PENDING,
                'payment_status' => 'UNPAID',
                'payment_method' => 'MIDTRANS',
            ]);

            // Insert order items
            foreach ($cart->items as $item) {
                $product = $item->product;
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'price' => $item->product->price,
                ]);

                if($product->stock - $item->qty === 0) {
                    $product->update(['status' => ProductStatus::OUT_OF_STOCK]);
                }

                $item->delete();
            }

            // Midtrans payload
            $payload = [
                'transaction_details' => [
                    'order_id' => $order->code,
                    'gross_amount' => $grandTotal,
                ],
                'customer_details' => [
                    'first_name' => $customer->name,
                    'email' => Auth::user()->email,
                    'phone' => $customer->phone ?? '08123456789',
                ],
                'enabled_payments' => ['gopay', 'bank_transfer', 'qris', 'shopeepay'],
                'callbacks' => [
                    'finish' => route('shop.checkout.success', $order),
                ],
            ];

            $snapToken = Snap::getSnapToken($payload);

            $order->update([
                'midtrans_transaction_id' => $snapToken,
            ]);

            DB::commit();

            return view('shop.checkout.payment', compact('order', 'snapToken'));

        } catch (Exception $e) {
            DB::rollBack();
            report($e);
            return back()->withErrors('Failed to process checkout. Please try again.');
        }
    }

    public function success(Order $order)
    {
        try {
            $order->update([
                'status' => OrderStatus::PROCESSING,
                'payment_status' => 'PAID',
            ]);

            // Clear customer's cart
            $cart = Cart::where('customer_id', $order->customer_id)->first();
            if ($cart) {
                $cart->items()->delete();
                $cart->update(['total_price' => 0]);
            }

            return view('shop.checkout.success', compact('order'));

        } catch (Exception $e) {
            report($e);
            return redirect()->route('shop.cart.index')->withErrors('Error finalizing checkout. Please contact support.');
        }
    }
}