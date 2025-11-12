@extends('layouts.app')

@section('title', $product->name)

@section('content')
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

<div class="max-w-5xl mx-auto py-8 grid grid-cols-1 md:grid-cols-2 gap-8">
  {{-- Image --}}
  <div>
    <img src="{{ profile_image($product->image_path) }}" 
         alt="{{ $product->name }}" class="w-full h-96 object-cover rounded-lg border dark:border-gray-700">
  </div>

  {{-- Details --}}
  <div>
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $product->name }}</h1>
    <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $product->category->name ?? 'Uncategorized' }}</p>
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