<?php

namespace App\Repositories;

use App\Interfaces\CartRepositoryInterface;
use App\Models\{Cart, CartItem, Product};
use Illuminate\Support\Facades\DB;
use Throwable;

class CartRepository implements CartRepositoryInterface
{
    public function getCart(int $customerId): Cart
    {
        return Cart::with('items.product')->firstOrCreate(
            ['customer_id' => $customerId],
            ['total_price' => 0]
        );
    }

    public function addToCart(int $customerId, Product $product): bool|string
    {
        try {
            if ($product->stock < 1) {
                return 'Product is out of stock.';
            }

            return DB::transaction(function () use ($customerId, $product) {

                $cart = Cart::firstOrCreate(
                    ['customer_id' => $customerId],
                    ['total_price' => 0]
                );

                $item = $cart->items()->where('product_id', $product->id)->first();

                if ($item) {
                    if ($item->qty + 1 > $product->stock) {
                        return 'Not enough stock available.';
                    }

                    $item->qty++;
                    $item->subtotal = $item->qty * $product->price;
                    $item->save();

                } else {
                    $cart->items()->create([
                        'product_id' => $product->id,
                        'qty'        => 1,
                        'subtotal'   => $product->price,
                    ]);
                }

                $cart->update([
                    'total_price' => $cart->items()->sum('subtotal')
                ]);

                return true;
            });

        } catch (Throwable $e) {
            report($e);
            return 'Failed to add item to cart.';
        }
    }

    public function updateItem(CartItem $item, int $qty): bool|string
    {
        try {
            if ($qty > $item->product->stock) {
                return 'Not enough stock available.';
            }

            return DB::transaction(function () use ($item, $qty) {

                $item->update([
                    'qty'      => $qty,
                    'subtotal' => $item->product->price * $qty,
                ]);

                $item->cart->update([
                    'total_price' => $item->cart->items()->sum('subtotal'),
                ]);

                return true;
            });

        } catch (Throwable $e) {
            report($e);
            return 'Failed to update cart.';
        }
    }

    public function removeItem(CartItem $item): bool
    {
        try {
            return DB::transaction(function () use ($item) {

                $cart = $item->cart;

                $item->delete();

                $cart->update([
                    'total_price' => $cart->items()->sum('subtotal')
                ]);

                return true;
            });

        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function clearCart(int $customerId): bool
    {
        try {
            return DB::transaction(function () use ($customerId) {

                $cart = Cart::where('customer_id', $customerId)->first();

                if ($cart) {
                    $cart->items()->delete();
                    $cart->update(['total_price' => 0]);
                }

                return true;
            });

        } catch (Throwable $e) {
            report($e);
            return false;
        }
    }

    public function buyNow(int $customerId, Product $product): bool|string
    {
        try {
            if ($product->stock < 1) {
                return 'Product is out of stock.';
            }

            return DB::transaction(function () use ($customerId, $product) {

                $cart = Cart::firstOrCreate(
                    ['customer_id' => $customerId],
                    ['total_price' => 0]
                );

                $cart->items()->delete();

                $cart->items()->create([
                    'product_id' => $product->id,
                    'qty'        => 1,
                    'subtotal'   => $product->price,
                ]);

                $cart->update(['total_price' => $product->price]);

                return true;
            });

        } catch (Throwable $e) {
            report($e);
            return 'Failed to process Buy Now.';
        }
    }
}