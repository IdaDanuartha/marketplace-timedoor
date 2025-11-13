<?php

namespace App\View\Components;

use App\Models\Cart;
use App\Models\CartItem;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $cart_items_count = 0;
        $wishlists_count = 0;

        if (Auth::check() && Auth::user()->customer) {
            $customer = Auth::user()->customer;

            $cart = Cart::with('items')->where('customer_id', $customer->id)->first();
            if ($cart) {
                $cart_items_count = $cart->items->count();
            }

            $wishlists_count = $customer->wishlists()->count();
        }

        return view('components.sidebar', compact('cart_items_count', 'wishlists_count'));
    }
}
