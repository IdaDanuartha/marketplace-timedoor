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
        $cart_items_count = Cart::where('customer_id', Auth::user()->customer->id)
            ->withCount('items')
            ->first()
            ?->items_count ?? 0;
        $wishlists_count = Auth::user()->customer
            ?->wishlists()
            ->count() ?? 0;

        return view('components.sidebar', compact('cart_items_count', 'wishlists_count'));
    }
}
