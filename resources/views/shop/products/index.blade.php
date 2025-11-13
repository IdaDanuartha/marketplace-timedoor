@extends('layouts.app')

@section('title', 'Shop Products')

@section('content')
<div class="max-w-6xl mx-auto py-8">
  <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">Shop Products</h1>

  {{-- Alerts --}}
  @if (session('success'))
    <div class="p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg mb-4">{{ session('success') }}</div>
  @endif
  @if ($errors->any())
    <div class="p-3 bg-red-100 border border-red-300 text-red-800 rounded-lg mb-4">{{ $errors->first() }}</div>
  @endif

  {{-- Filter Form --}}
  <form method="GET" class="mb-6 grid md:grid-cols-5 gap-4">

    <!-- Search -->
    <div class="md:col-span-5">
        <input 
            type="text" 
            name="search" 
            value="{{ request('search') }}" 
            placeholder="Search products..."
            class="w-full border bg-white rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white"
        >
    </div>

    <!-- Category -->
    <div>
        <select name="category" class="select2 w-full" data-placeholder="Category">
            <option value="">All Categories</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" 
                    {{ request('category') == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Vendor -->
    <div>
        <select name="vendor" class="select2 w-full" data-placeholder="Vendor">
            <option value="">All Vendors</option>
            @foreach ($vendors as $v)
                <option value="{{ $v->id }}" 
                    {{ request('vendor') == $v->id ? 'selected' : '' }}>
                    {{ $v->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Price -->
    <div>
        <select name="price" class="select2 w-full" data-placeholder="Price Range">
            <option value="">Any Price</option>

            <option value="0-100000" {{ request('price') == '0-100000' ? 'selected' : '' }}>
                Under 100k
            </option>
            <option value="100000-300000" {{ request('price') == '100000-300000' ? 'selected' : '' }}>
                100k - 300k
            </option>
            <option value="300000-500000" {{ request('price') == '300000-500000' ? 'selected' : '' }}>
                300k - 500k
            </option>
            <option value="500000-1000000" {{ request('price') == '500000-1000000' ? 'selected' : '' }}>
                Above 500k
            </option>
        </select>
    </div>

    <!-- Sort -->
    <div>
        <select name="sort" class="select2 w-full" data-placeholder="Sort By">
            <option value="">Sort By</option>
            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price Low → High</option>
            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price High → Low</option>
        </select>
    </div>

    <!-- Button -->
    <div class="md:col-span-5 flex justify-end">
        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Apply Filters
        </button>
    </div>

  </form>


  {{-- Product Grid --}}
  <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @forelse ($products as $product)
      <div class="border rounded-lg bg-white dark:bg-gray-900 dark:border-gray-800 p-4 flex flex-col justify-between relative hover:shadow-md transition">
        {{-- Wishlist --}}
        <form action="{{ route('shop.wishlist.toggle', $product) }}" method="POST" class="absolute top-3 right-3">@csrf
          @php
            $isWished = Auth::check() && Auth::user()->customer
                ? Auth::user()->customer->wishlists()->where('product_id', $product->id)->exists()
                : false;
          @endphp
          <button type="submit" title="Add to Wishlist">
            @if ($isWished)
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                class="w-6 h-6 text-red-500 hover:text-red-600" viewBox="0 0 24 24">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5a5.5 5.5 0 0111 0 5.5 5.5 0 0111 0c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" />
              </svg>
            @else
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                class="w-6 h-6 text-gray-400 hover:text-red-500" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4.318 6.318a5.5 5.5 0 017.778 0L12 6.939l-.096-.096a5.5 5.5 0 117.778 7.778L12 21l-7.682-7.379a5.5 5.5 0 010-7.303z" />
              </svg>
            @endif
          </button>
        </form>

        <a href="{{ route('shop.products.show', $product) }}">
          <img src="{{ profile_image($product->image_path) }}" alt="{{ $product->name }}"
            class="w-full h-48 object-cover rounded mb-3">
          <h2 class="font-semibold text-gray-800 dark:text-white truncate">{{ $product->name }}</h2>
          <p class="text-sm text-gray-500">{{ $product->category->name ?? 'Uncategorized' }}</p>
          <p class="text-blue-600 font-semibold mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>

          {{-- Rating --}}
          <div class="flex items-center gap-1 mt-1">
            @php $avg = round($product->average_rating, 1); @endphp
            @for ($i = 1; $i <= 5; $i++)
              <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $i <= $avg ? 'currentColor' : 'none' }}"
                class="w-4 h-4 {{ $i <= $avg ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.948a1 1 0 00.95.69h4.148c.969 0 1.371 1.24.588 1.81l-3.36 2.44a1 1 0 00-.364 1.118l1.286 3.948c.3.921-.755 1.688-1.54 1.118l-3.36-2.44a1 1 0 00-1.176 0l-3.36 2.44c-.785.57-1.84-.197-1.54-1.118l1.286-3.948a1 1 0 00-.364-1.118l-3.36-2.44c-.783-.57-.38-1.81.588-1.81h4.148a1 1 0 00.95-.69l1.286-3.948z" />
              </svg>
            @endfor
            <span class="text-xs text-gray-500">({{ $avg }}/5)</span>
          </div>
        </a>

        {{-- Buttons --}}
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

@push('js')
<script>
  $(document).ready(function() {
    $('.select2').select2({
      width: '100%',
      allowClear: true,
      placeholder: function() {
        return $(this).data('placeholder');
      }
    });
  });
</script>
@endpush