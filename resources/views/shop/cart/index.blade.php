@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-5xl mx-auto py-8 space-y-6">
  <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Shopping Cart</h1>

  @if (session('success'))
    <div class="p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg">
      {{ session('success') }}
    </div>
  @endif

  @forelse ($cart->items as $item)
    <div class="flex items-center justify-between p-4 border dark:border-white/10 rounded-lg bg-white dark:bg-gray-900">
      <div class="flex items-center gap-4">
        <a href="{{ route('shop.products.show', $item->product) }}">
          <img src="{{ profile_image($item->product->image_path) }}" 
             class="w-16 h-16 rounded object-cover">
        </a>
        <div>
          <a href="{{ route('shop.products.show', $item->product) }}">
            <h3 class="font-semibold text-gray-900 dark:text-white">{{ $item->product->name }}</h3>
          </a>
          <p class="text-gray-500 dark:text-gray-400">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>

          <form action="{{ route('shop.cart.update', $item) }}" method="POST" class="flex items-center gap-2 mt-2">
            @csrf @method('PATCH')
            <input type="number" name="qty" value="{{ $item->qty }}" min="1"
              class="w-16 border rounded px-2 py-1 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
            <button class="text-sm text-blue-600 hover:underline">Update</button>
          </form>
        </div>
      </div>

      <div class="text-right">
        <p class="font-semibold text-blue-600">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
        <form action="{{ route('shop.cart.destroy', $item) }}" method="POST">
          @csrf @method('DELETE')
          <button class="text-sm text-red-500 hover:text-red-700 mt-1">Remove</button>
        </form>
      </div>
    </div>
  @empty
    <p class="text-gray-500 dark:text-gray-400">Your cart is empty.</p>
  @endforelse

  @if ($cart->items->count())
    <div class="flex justify-between items-center mt-6">
      <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
        Total: <span class="text-blue-600">Rp {{ number_format($total, 0, ',', '.') }}</span>
      </h3>
      <div class="flex items-center gap-3">
        <form action="{{ route('shop.cart.clear') }}" method="POST">
          @csrf
          <button class="px-5 py-3 text-sm bg-gray-100 dark:text-white dark:border-white/10 dark:bg-gray-800 border rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700">
            Clear Cart
          </button>
        </form>

        <form action="{{ route('shop.cart.checkout') }}" method="GET">
          <button class="px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Proceed to Checkout
          </button>
        </form>
      </div>
    </div>
  @endif
</div>
@endsection