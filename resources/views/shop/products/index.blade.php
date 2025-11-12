@extends('layouts.app')

@section('title', 'Shop Products')

@section('content')
<div class="max-w-6xl mx-auto py-8">
  <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Shop Products</h1>

  {{-- Alert --}}
  @if(session('success'))
    <div class="p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg">
      {{ session('success') }}
    </div>
  @endif
  @if($errors->any())
    <div class="p-3 bg-red-100 border border-red-300 text-red-800 rounded-lg">
      {{ $errors->first() }}
    </div>
  @endif

  {{-- Search Bar --}}
  <form method="GET" class="mb-6 flex gap-2 mt-4">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
      class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
    <button class="bg-blue-600 text-white px-4 rounded-lg hover:bg-blue-700">Search</button>
  </form>

  {{-- Product Grid --}}
  <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @forelse ($products as $product)
      <div class="border rounded-lg bg-white dark:bg-gray-900 dark:border-gray-800 p-4 flex flex-col justify-between">
        <a href="{{ route('shop.products.show', $product) }}">
          <img src="{{ profile_image($product->image_path) }}" 
               alt="{{ $product->name }}" class="w-full h-48 object-cover rounded mb-3">
          <h2 class="font-semibold text-gray-800 dark:text-white truncate">{{ $product->name }}</h2>
          <p class="text-sm text-gray-500">{{ $product->category->name ?? 'Uncategorized' }}</p>
          <p class="text-blue-600 font-semibold mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
        </a>
        <div class="mt-4 flex gap-2">
          <form action="{{ route('shop.cart.add', $product) }}" method="POST">@csrf
            <button class="px-3 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 w-full">Add to Cart</button>
          </form>
          <form action="{{ route('shop.cart.buyNow', $product) }}" method="POST">@csrf
            <button class="px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 w-full">Buy Now</button>
          </form>
        </div>
      </div>
    @empty
      <p class="text-gray-500 dark:text-gray-400 col-span-full">No products found.</p>
    @endforelse
  </div>

  <div class="mt-8">{{ $products->links() }}</div>
</div>
@endsection