@extends('layouts.app')

@section('title', $product->name)

@section('content')
{{-- Alerts --}}
@if(session('success'))
  <div class="p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg mb-4">{{ session('success') }}</div>
@endif
@if($errors->any())
  <div class="p-3 bg-red-100 border border-red-300 text-red-800 rounded-lg mb-4">{{ $errors->first() }}</div>
@endif

<div class="max-w-5xl mx-auto py-8 grid grid-cols-1 md:grid-cols-2 gap-8">
  {{-- Image --}}
  <div>
    <img src="{{ profile_image($product->image_path) }}" alt="{{ $product->name }}"
         class="w-full h-96 object-cover rounded-lg border dark:border-gray-700">
  </div>

  {{-- Details --}}
  <div>
    <div class="flex items-start justify-between">
      <div>
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $product->name }}</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $product->category->name ?? 'Uncategorized' }}</p>
      </div>

      {{-- Wishlist Toggle --}}
      <form action="{{ route('shop.wishlist.toggle', $product) }}" method="POST">@csrf
        @php
          $isWished = Auth::check() && Auth::user()->customer
            ? Auth::user()->customer->wishlists()->where('product_id', $product->id)->exists()
            : false;
        @endphp
        <button type="submit" title="Add to Wishlist">
          @if($isWished)
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-7 h-7 text-red-500 hover:text-red-600" viewBox="0 0 24 24">
              <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5a5.5 5.5 0 0111 0 5.5 5.5 0 0111 0c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
          @else
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" class="w-7 h-7 text-gray-400 hover:text-red-500" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a5.5 5.5 0 017.778 0L12 6.939l-.096-.096a5.5 5.5 0 117.778 7.778L12 21l-7.682-7.379a5.5 5.5 0 010-7.303z" />
            </svg>
          @endif
        </button>
      </form>
    </div>

    <p class="text-2xl text-blue-600 font-semibold mt-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

    <p class="mt-6 text-gray-700 dark:text-gray-300 leading-relaxed">
      {!! $product->description ?? 'No description available for this product.' !!}
    </p>

    <div class="mt-8 flex gap-3">
      <form action="{{ route('shop.cart.add', $product) }}" method="POST">@csrf
        <button class="px-5 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">Add to Cart</button>
      </form>
      <form action="{{ route('shop.cart.buyNow', $product) }}" method="POST">@csrf
        <button class="px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Buy Now</button>
      </form>
    </div>
  </div>
</div>
@endsection