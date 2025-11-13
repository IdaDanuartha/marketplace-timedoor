@extends('layouts.app')

@section('title', $product->name)

@section('content')
  {{-- Alerts --}}
  @if(session('success'))
    <div class="p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg mb-4">
      {{ session('success') }}
    </div>
  @endif

  @if($errors->any())
    <div class="p-3 bg-red-100 border border-red-300 text-red-800 rounded-lg mb-4">
      {{ $errors->first() }}
    </div>
  @endif

  <div class="max-w-5xl mx-auto py-8 grid grid-cols-1 md:grid-cols-2 gap-8">
    {{-- Product Image --}}
    <div>
      <img src="{{ profile_image($product->image_path) }}"
           alt="{{ $product->name }}"
           class="w-full h-96 object-cover rounded-lg border dark:border-gray-700">
    </div>

    {{-- Product Details --}}
    <div>
      {{-- Header --}}
      <div class="flex items-start justify-between">
        <div>
          <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $product->name }}</h1>
          <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $product->category->name ?? 'Uncategorized' }}</p>
        </div>

        {{-- Wishlist --}}
        <form action="{{ route('shop.wishlist.toggle', $product) }}" method="POST">
          @csrf
          @php
            $isWished = Auth::check() && Auth::user()->customer
              ? Auth::user()->customer->wishlists()->where('product_id', $product->id)->exists()
              : false;
          @endphp
          <button type="submit" title="Add to Wishlist">
            @if($isWished)
              <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                   class="w-7 h-7 text-red-500 hover:text-red-600" viewBox="0 0 24 24">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5a5.5 5.5 0 0111 0 5.5 5.5 0 0111 0c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
              </svg>
            @else
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor"
                   class="w-7 h-7 text-gray-400 hover:text-red-500" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4.318 6.318a5.5 5.5 0 017.778 0L12 6.939l-.096-.096a5.5 5.5 0 117.778 7.778L12 21l-7.682-7.379a5.5 5.5 0 010-7.303z"/>
              </svg>
            @endif
          </button>
        </form>
      </div>

      {{-- Price --}}
      <p class="text-2xl text-blue-600 font-semibold mt-4">
        Rp {{ number_format($product->price, 0, ',', '.') }}
      </p>

      {{-- Description --}}
      <p class="mt-6 text-gray-700 dark:text-gray-300 leading-relaxed">
        {!! $product->description ?? 'No description available for this product.' !!}
      </p>

      {{-- Add to Cart & Buy Now --}}
      <div class="mt-8 flex gap-3">
        <form action="{{ route('shop.cart.add', $product) }}" method="POST">
          @csrf
          <button class="px-5 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">Add to Cart</button>
        </form>

        <form action="{{ route('shop.cart.buyNow', $product) }}" method="POST">
          @csrf
          <button class="px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Buy Now</button>
        </form>
      </div>

      <hr class="my-10 border-gray-300 dark:border-gray-700">

      {{-- Reviews Section --}}
      <div class="mt-6 space-y-6" x-data="{ filter: 0 }">
        {{-- Title --}}
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
          Customer Reviews
          <span class="text-sm text-gray-500">({{ $product->reviews->count() }})</span>
        </h2>

        {{-- Average Rating --}}
        @php $avg = round($product->average_rating, 1); @endphp
        <div class="flex items-center gap-2">
          <div class="flex">
            @for ($i = 1; $i <= 5; $i++)
              <svg xmlns="http://www.w3.org/2000/svg" 
                   fill="{{ $i <= $avg ? 'currentColor' : 'none' }}"
                   class="w-5 h-5 {{ $i <= $avg ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
                   viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11.049 2.927c.3-.921 1.603-.921 1.902 
                         0l1.286 3.948a1 1 0 00.95.69h4.148c.969 
                         0 1.371 1.24.588 1.81l-3.36 
                         2.44a1 1 0 00-.364 1.118l1.286 
                         3.948c.3.921-.755 1.688-1.54 
                         1.118l-3.36-2.44a1 1 0 00-1.176 
                         0l-3.36 2.44c-.785.57-1.84-.197-1.54-1.118l1.286-3.948a1 
                         1 0 00-.364-1.118l-3.36-2.44c-.783-.57-.38-1.81.588-1.81h4.148a1 
                         1 0 00.95-.69l1.286-3.948z"/>
              </svg>
            @endfor
          </div>
          <span class="text-sm text-gray-600 dark:text-gray-400">{{ $avg }}/5</span>
        </div>

        {{-- Review Form --}}
        @auth
          @if (auth()->user()->customer)
            <form action="{{ route('shop.reviews.store', $product) }}" method="POST" class="mt-4 space-y-3" x-data="{ rating: 0 }">
              @csrf
              <div class="flex items-center gap-2">
                <label class="text-sm text-gray-600 dark:text-gray-300">Your Rating:</label>
                <div class="flex items-center gap-1">
                  @for ($i = 1; $i <= 5; $i++)
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor" class="w-7 h-7 cursor-pointer transition"
                         :class="rating >= {{ $i }} ? 'text-yellow-400 fill-yellow-400' : 'text-gray-300 dark:text-gray-600'"
                         @click="rating = {{ $i }}">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 
                               0l1.286 3.948a1 1 0 00.95.69h4.148c.969 
                               0 1.371 1.24.588 1.81l-3.36 
                               2.44a1 1 0 00-.364 1.118l1.286 
                               3.948c.3.921-.755 1.688-1.54 
                               1.118l-3.36-2.44a1 1 0 00-1.176 
                               0l-3.36 2.44c-.785.57-1.84-.197-1.54-1.118l1.286-3.948a1 
                               1 0 00-.364-1.118l-3.36-2.44c-.783-.57-.38-1.81.588-1.81h4.148a1 
                               1 0 00.95-.69l1.286-3.948z"/>
                    </svg>
                  @endfor
                </div>
                <input type="hidden" name="rating" x-model="rating">
              </div>

              <textarea name="comment" rows="3" placeholder="Write your review..."
                        class="w-full border rounded-lg p-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white"></textarea>

              <button type="submit"
                      class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm disabled:opacity-50"
                      :disabled="rating === 0">
                Submit Review
              </button>
            </form>
          @endif
        @endauth

        {{-- Rating Statistics --}}
        @php
          $totalReviews = $product->reviews->count();
          $ratings = [];
          for ($i = 5; $i >= 1; $i--) {
              $ratings[$i] = $product->reviews()->where('rating', $i)->count();
          }
        @endphp

        @if($totalReviews > 0)
          <div class="mt-6 border border-gray-200 dark:border-gray-800 rounded-lg p-4 bg-gray-50 dark:bg-gray-800/50">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-2">
                <span class="text-4xl font-bold text-yellow-400">{{ number_format($avg, 1) }}</span>
                <div class="flex flex-col">
                  <div class="flex">
                    @for ($i = 1; $i <= 5; $i++)
                      <svg xmlns="http://www.w3.org/2000/svg" 
                           fill="{{ $i <= $avg ? 'currentColor' : 'none' }}"
                           class="w-5 h-5 {{ $i <= $avg ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
                           viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11.049 2.927c.3-.921 1.603-.921 1.902 
                                 0l1.286 3.948a1 1 0 00.95.69h4.148c.969 
                                 0 1.371 1.24.588 1.81l-3.36 
                                 2.44a1 1 0 00-.364 1.118l1.286 
                                 3.948c.3.921-.755 1.688-1.54 
                                 1.118l-3.36-2.44a1 1 0 00-1.176 
                                 0l-3.36 2.44c-.785.57-1.84-.197-1.54-1.118l1.286-3.948a1 
                                 1 0 00-.364-1.118l-3.36-2.44c-.783-.57-.38-1.81.588-1.81h4.148a1 
                                 1 0 00.95-.69l1.286-3.948z"/>
                      </svg>
                    @endfor
                  </div>
                  <p class="text-sm text-gray-500">{{ $totalReviews }} Reviews</p>
                </div>
              </div>
            </div>

            {{-- Rating Bars --}}
            <div class="mt-4 space-y-1">
              @foreach($ratings as $star => $count)
                @php $percent = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0; @endphp
                <div class="flex items-center gap-3">
                  <button type="button"
                          class="flex items-center gap-1 text-sm text-gray-700 dark:text-gray-300"
                          @click="filter = {{ $star }}">
                    <span>{{ $star }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                         class="w-4 h-4 text-yellow-400" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 
                               3.948a1 1 0 00.95.69h4.148c.969 
                               0 1.371 1.24.588 1.81l-3.36 
                               2.44a1 1 0 00-.364 1.118l1.286 
                               3.948c.3.921-.755 1.688-1.54 
                               1.118l-3.36-2.44a1 1 0 00-1.176 
                               0l-3.36 2.44c-.785.57-1.84-.197-1.54-1.118l1.286-3.948a1 
                               1 0 00-.364-1.118l-3.36-2.44c-.783-.57-.38-1.81.588-1.81h4.148a1 
                               1 0 00.95-.69l1.286-3.948z"/>
                    </svg>
                  </button>
                  <div class="flex-1 bg-gray-200 dark:bg-gray-700 h-2 rounded-full overflow-hidden">
                    <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $percent }}%;"></div>
                  </div>
                  <span class="text-sm text-gray-500 w-8 text-right">{{ $count }}</span>
                </div>
              @endforeach
            </div>

            {{-- Clear Filter --}}
            <div class="text-right mt-3">
              <button type="button" class="text-xs text-blue-600 hover:underline"
                      @click="filter = 0" x-show="filter !== 0">
                Clear Filter
              </button>
            </div>

            {{-- Filtered Reviews --}}
            <div class="space-y-4 mt-6">
              @foreach ($product->reviews()->latest()->get() as $review)
                <template x-if="filter === 0 || filter === {{ $review->rating }}">
                  <div class="border-b border-gray-200 dark:border-gray-700 pb-3 flex items-start gap-3">
                    {{-- Avatar --}}
                    @php
                      $user = $review->customer?->user;
                      $avatar = $user?->profile_image
                        ?? 'https://ui-avatars.com/api/?name=' . urlencode($review->customer->name ?? 'User') . '&background=random';
                    @endphp
                    <img src="{{ $avatar }}" alt="Avatar"
                         class="w-10 h-10 rounded-full object-cover border dark:border-gray-700">

                    {{-- Review Body --}}
                    <div class="flex-1">
                      <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                          <p class="font-semibold text-gray-800 dark:text-white">
                            {{ $review->customer->name ?? 'Anonymous' }}
                          </p>
                          <div class="flex">
                            @for ($i = 1; $i <= 5; $i++)
                              <svg xmlns="http://www.w3.org/2000/svg"
                                   fill="{{ $i <= $review->rating ? 'currentColor' : 'none' }}"
                                   class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
                                   viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11.049 2.927c.3-.921 1.603-.921 1.902 
                                         0l1.286 3.948a1 1 0 00.95.69h4.148c.969 
                                         0 1.371 1.24.588 1.81l-3.36 
                                         2.44a1 1 0 00-.364 1.118l1.286 
                                         3.948c.3.921-.755 1.688-1.54 
                                         1.118l-3.36-2.44a1 1 0 00-1.176 
                                         0l-3.36 2.44c-.785.57-1.84-.197-1.54-1.118l1.286-3.948a1 
                                         1 0 00-.364-1.118l-3.36-2.44c-.783-.57-.38-1.81.588-1.81h4.148a1 
                                         1 0 00.95-.69l1.286-3.948z"/>
                              </svg>
                            @endfor
                          </div>
                        </div>
                        <span class="text-xs text-gray-500 dark:text-gray-400">
                          {{ optional($review->created_at)->diffForHumans() ?? '—' }}
                        </span>
                      </div>
                      <p class="text-sm text-gray-700 dark:text-gray-300 mt-2">{{ $review->comment }}</p>

                      {{-- Delete (only for owner) --}}
                      @if(auth()->check() && $review->customer_id === auth()->user()->customer?->id)
                        <form action="{{ route('shop.reviews.destroy', $review) }}" method="POST" class="mt-2">
                          @csrf
                          @method('DELETE')
                          <button class="text-xs text-red-600 hover:underline">Delete</button>
                        </form>
                      @endif
                    </div>
                  </div>
                </template>
              @endforeach
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection