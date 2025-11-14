<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\CheckoutProcessRequest;
use App\Interfaces\OrderRepositoryInterface;
use App\Services\RajaOngkirService;
use App\Models\{Cart, Order};
use App\Policies\CheckoutPolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class CheckoutController extends Controller
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepo
    ) {}

    public function index(RajaOngkirService $rajaOngkir)
    {
        try {
            $customer = Auth::user()->customer;
            $cart = Cart::with('items.product')
                ->where('customer_id', $customer->id)
                ->firstOrFail();

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

        } catch (Throwable $e) {
            Log::error('Checkout index failed: ' . $e->getMessage());
            return back()->withErrors('Something went wrong while loading checkout.');
        }
    }


    public function process(CheckoutProcessRequest $request)
    {
        try {
            $result = $this->orderRepo->processCheckout($request->only(
                'address_id',
                'shipping_service'
            ));

            if (isset($result['error'])) {
                return back()->withErrors($result['error']);
            }

            return view('shop.checkout.payment', [
                'order'     => $result['order'],
                'snapToken' => $result['snapToken'],
            ]);

        } catch (Throwable $e) {
            Log::error('Checkout process failed: ' . $e->getMessage());
            return back()->withErrors('Failed to process checkout.');
        }
    }


    public function success(Order $order)
    {
        try {
            $success = $this->orderRepo->finalizeSuccess($order);

            if (!$success) {
                return redirect()->route('shop.cart.index')
                    ->withErrors('Error finalizing checkout. Please contact support.');
            }

            return view('shop.checkout.success', compact('order'));

        } catch (Throwable $e) {
            Log::error('Checkout success finalize failed: ' . $e->getMessage());
            return redirect()->route('shop.cart.index')
                ->withErrors('Something went wrong while finalizing your order.');
        }
    }
}