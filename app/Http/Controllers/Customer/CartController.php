<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\{Cart, CartItem, Product};
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer;

        $cart = Cart::with('items.product')->firstOrCreate(
            ['customer_id' => $customer->id],
            ['total_price' => 0]
        );

        $total = $cart->items->sum('subtotal');

        return view('shop.cart.index', compact('cart', 'total'));
    }

    public function store(Product $product)
    {
        $customer = Auth::user()->customer;

        $cart = Cart::firstOrCreate(
            ['customer_id' => $customer->id],
            ['total_price' => 0]
        );

        $item = $cart->items()->where('product_id', $product->id)->first();

        if ($item) {
            $item->qty++;
            $item->subtotal = $item->qty * $product->price;
            $item->save();
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'qty' => 1,
                'subtotal' => $product->price,
            ]);
        }

        $cart->update(['total_price' => $cart->items()->sum('subtotal')]);

        return back()->with('success', 'Product added to cart.');
    }

    public function update(Request $request, CartItem $item)
    {
        $request->validate(['qty' => 'required|integer|min:1']);

        $item->update([
            'qty' => $request->qty,
            'subtotal' => $item->product->price * $request->qty,
        ]);

        $item->cart->update(['total_price' => $item->cart->items()->sum('subtotal')]);

        return back()->with('success', 'Cart updated.');
    }

    public function destroy(CartItem $item)
    {
        $cart = $item->cart;
        $item->delete();
        $cart->update(['total_price' => $cart->items()->sum('subtotal')]);

        return back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        $customer = Auth::user()->customer;
        $cart = Cart::where('customer_id', $customer->id)->first();

        if ($cart) {
            $cart->items()->delete();
            $cart->update(['total_price' => 0]);
        }

        return back()->with('success', 'Cart cleared.');
    }

    public function checkout()
    {
        $customer = Auth::user()->customer;
        $cart = Cart::with('items.product')->where('customer_id', $customer->id)->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('shop.cart.index')->withErrors('Your cart is empty.');
        }

        return redirect()->route('shop.checkout.index');
    }

    public function buyNow(Product $product)
    {
        $customer = Auth::user()->customer;

        $cart = Cart::firstOrCreate(
            ['customer_id' => $customer->id],
            ['total_price' => 0]
        );

        $cart->items()->delete();

        $cart->items()->create([
            'product_id' => $product->id,
            'qty' => 1,
            'subtotal' => $product->price,
        ]);

        $cart->update(['total_price' => $product->price]);

        return redirect()->route('shop.checkout.index')->with('success', 'Proceed to checkout.');
    }

}