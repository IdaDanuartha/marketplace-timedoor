<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cart\UpdateCartController;
use App\Interfaces\CartRepositoryInterface;
use App\Models\{Cart, Product, CartItem};
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Throwable;

class CartController extends Controller
{
    public function __construct(private readonly CartRepositoryInterface $cartRepo) {}

    public function index()
    {
        $this->authorize('viewAny', Cart::class);
        try {
            $customer = Auth::user()->customer;
            $cart = $this->cartRepo->getCart($customer->id);

            $total = $cart->items->sum('subtotal');

            return view('shop.cart.index', compact('cart', 'total'));

        } catch (Throwable $e) {
            report($e);
            return back()->withErrors('Failed to load your cart.');
        }
    }

    public function store(Product $product)
    {
        $this->authorize('viewAny', Cart::class);
        try {
            $customer = Auth::user()->customer;

            $result = $this->cartRepo->addToCart($customer->id, $product);

            if ($result !== true) {
                return back()->withErrors($result);
            }

            return back()->with('success', 'Product added to cart.');

        } catch (Throwable $e) {
            report($e);
            return back()->withErrors('Failed to add product to cart.');
        }
    }

    public function update(UpdateCartController $request, CartItem $item)
    {
        $this->authorize('update', $item->cart);
        try {
            $result = $this->cartRepo->updateItem($item, $request->qty);

            if ($result !== true) {
                return back()->withErrors($result);
            }

            return back()->with('success', 'Cart updated.');

        } catch (Throwable $e) {
            report($e);
            return back()->withErrors('Failed to update cart.');
        }
    }

    public function destroy(CartItem $item)
    {
        $this->authorize('delete', $item->cart);
        try {
            $this->cartRepo->removeItem($item);
            return back()->with('success', 'Item removed from cart.');

        } catch (Throwable $e) {
            report($e);
            return back()->withErrors('Failed to remove item from cart.');
        }
    }

    public function clear()
    {
        $this->authorize('viewAny', Cart::class);
        try {
            $customer = Auth::user()->customer;
            $this->cartRepo->clearCart($customer->id);

            return back()->with('success', 'Cart cleared.');

        } catch (Throwable $e) {
            report($e);
            return back()->withErrors('Failed to clear cart.');
        }
    }

    public function checkout()
    {
        $this->authorize('viewAny', Cart::class);
        try {
            $customer = Auth::user()->customer;
            $cart = $this->cartRepo->getCart($customer->id);

            if ($cart->items->isEmpty()) {
                return redirect()->route('shop.cart.index')
                    ->withErrors('Your cart is empty.');
            }

            return redirect()->route('shop.checkout.index');

        } catch (Throwable $e) {
            report($e);
            return back()->withErrors('Error preparing checkout.');
        }
    }

    public function buyNow(Product $product)
    {
        try {
            $customer = Auth::user()->customer;

            $result = $this->cartRepo->buyNow($customer->id, $product);

            if ($result !== true) {
                return back()->withErrors($result);
            }

            return redirect()->route('shop.checkout.index')
                ->with('success', 'Proceed to checkout.');

        } catch (Throwable $e) {
            report($e);
            return back()->withErrors('Failed to process Buy Now.');
        }
    }
}