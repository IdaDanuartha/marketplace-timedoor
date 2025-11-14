<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\{Cart, Order, OrderItem};
use App\Enum\OrderStatus;
use App\Enum\ProductStatus;
use App\Services\RajaOngkirService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Exception;

class CheckoutController extends Controller
{
    public function index(RajaOngkirService $rajaOngkir)
    {
        $customer = Auth::user()->customer;
        $cart = Cart::with('items.product')->where('customer_id', $customer->id)->firstOrFail();
        $addresses = $customer->addresses;

        $subtotal = $cart->items->sum('subtotal');

        $shippingOptions = [];
        $shippingCost = 0;

        if ($addresses->isNotEmpty()) {
            $address = $addresses->firstWhere('is_default', true) ?? $addresses->first();

            if ($address->district_id) {
                $shippingOptions = $rajaOngkir->calculateDomesticCost(
                    destination: $address->district_id,
                    weight: 1.00 * $cart->items->count()
                );

                // if (count($shippingOptions)) {
                //     $shippingCost = $shippingOptions[0]['cost'];
                // }
            }
        }

        $grandTotal = $subtotal + $shippingCost;

        return view('shop.checkout.index', compact(
            'cart',
            'addresses',
            'subtotal',
            'shippingOptions',
            'shippingCost',
            'grandTotal'
        ));
    }

    public function process(Request $request)
    {
        $request->validate([
            'address_id'        => 'required|exists:addresses,id',
            'shipping_service'  => 'required|string'
        ]);

        $customer = Auth::user()->customer;

        $cart = Cart::with('items.product')
            ->where('customer_id', $customer->id)
            ->first();

        if (!$cart || $cart->items->isEmpty()) {
            return back()->withErrors('Your cart is empty.');
        }

        // Hitung subtotal
        $subtotal = $cart->items->sum('subtotal');

        DB::beginTransaction();

        try {
            // Parse shipping data dari select box
            [$courier, $service, $shippingCost] = explode('|', $request->shipping_service);
            $shippingCost = (int) $shippingCost;

            // Total akhir
            $grandTotal = $subtotal + $shippingCost;

            // Create new order
            $order = Order::create([
                'code'              => 'ORD-' . strtoupper(Str::random(8)),
                'customer_id'       => $customer->id,
                'address_id'        => $request->address_id,
                'shipping_cost'     => $shippingCost,
                'shipping_service'  => "{$courier} {$service}",
                'total_price'       => $subtotal,
                'grand_total'       => $grandTotal,
                'status'            => OrderStatus::PENDING,
                'payment_status'    => 'UNPAID',
                'payment_method'    => 'MIDTRANS',
            ]);

            // Insert order items + update stock
            foreach ($cart->items as $item) {
                $product = $item->product;

                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'qty'        => $item->qty,
                    'price'      => $product->price,
                ]);

                // Update stock & status product
                $remaining = $product->stock - $item->qty;
                $product->update([
                    'stock'  => $remaining,
                    'status' => $remaining === 0 ? ProductStatus::OUT_OF_STOCK : $product->status
                ]);

                $item->delete();
            }

            // Midtrans payload
            $payload = [
                'transaction_details' => [
                    'order_id'      => $order->code,
                    'gross_amount'  => $grandTotal,
                ],
                'customer_details' => [
                    'first_name' => $customer->name,
                    'email'      => Auth::user()->email,
                    'phone'      => $customer->phone ?? '08123456789',
                ],
                'enabled_payments' => [
                    'gopay',
                    'bank_transfer',
                    'qris',
                    'shopeepay'
                ],
                'callbacks' => [
                    'finish' => route('shop.checkout.success', $order),
                ],
            ];

            // Snap token
            $snapToken = Snap::getSnapToken($payload);

            // Simpan token
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