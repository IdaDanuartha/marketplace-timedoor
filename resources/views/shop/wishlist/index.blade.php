@extends('layouts.app')

@section('title', 'My Wishlist')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
  <h1 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">My Wishlist</h1>

  @if(session('success'))
    <div class="p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg">
      {{ session('success') }}
    </div>
  @endif

  @forelse($wishlist as $product)
    <div class="flex items-center justify-between p-4 border rounded-lg bg-white dark:bg-gray-900">
      <div class="flex items-center gap-4">
        <img src="{{ $product->image_url ?? asset('images/placeholder-image.svg') }}" class="w-16 h-16 object-cover rounded">
        <div>
          <h3 class="font-medium text-gray-900 dark:text-white">{{ $product->name }}</h3>
          <p class="text-sm text-gray-600 dark:text-gray-400">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
        </div>
      </div>
      <div class="flex gap-2">
        <form action="{{ route('shop.wishlist.destroy', $product) }}" method="POST">
          @csrf @method('DELETE')
          <button class="px-3 py-1 text-sm text-red-500 hover:text-red-700">Remove</button>
        </form>
        <a href="{{ route('shop.products.show', $product) }}"
          class="px-3 py-1 text-sm text-blue-600 hover:text-blue-800">View</a>
      </div>
    </div>
  @empty
    <p class="text-gray-500 dark:text-gray-400 text-sm">Your wishlist is empty.</p>
  @endforelse
</div>
@endsection
