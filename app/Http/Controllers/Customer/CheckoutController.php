<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\CheckoutProcessRequest;
use App\Interfaces\OrderRepositoryInterface;
use App\Services\RajaOngkirService;
use App\Models\{Cart, Order};
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct(private readonly OrderRepositoryInterface $orderRepo) {}

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


    public function process(CheckoutProcessRequest $request)
    {
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
    }


    public function success(Order $order)
    {
        $success = $this->orderRepo->finalizeSuccess($order);

        if (!$success) {
            return redirect()->route('shop.cart.index')
                ->withErrors('Error finalizing checkout. Please contact support.');
        }

        return view('shop.checkout.success', compact('order'));
    }
}