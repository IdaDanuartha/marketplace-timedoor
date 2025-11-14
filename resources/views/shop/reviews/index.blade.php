@extends('layouts.app')

@section('title', 'My Reviews')

@section('content')
{{-- Breadcrumb --}}
<nav class="text-sm text-gray-500">
  <ol class="flex items-center space-x-2">
    <li><a href="{{ route('dashboard.index') }}" class="hover:underline">Dashboard</a></li>
    <li>/</li>
    <li class="text-gray-700 dark:text-gray-300">Reviews</li>
  </ol>
</nav>

<div class="max-w-6xl mx-auto py-8">
  <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">My Reviews</h1>

  @if($reviews->isEmpty())
    <p class="text-gray-500 dark:text-gray-400">You haven’t reviewed any products yet.</p>
  @else
    <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
      @foreach($reviews as $review)
        <div class="border rounded-lg bg-white dark:bg-gray-900 dark:border-gray-800 p-4 space-y-3">
          <a href="{{ route('shop.products.show', $review->product) }}">
            <img src="{{ profile_image($review->product->image_path) }}" 
                 alt="{{ $review->product->name }}"
                 class="w-full h-40 object-cover rounded-lg mb-2">
            <h2 class="font-semibold text-gray-800 dark:text-white">{{ $review->product->name }}</h2>
            <div class="flex items-center mt-1">
              @for($i = 1; $i <= 5; $i++)
                <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $i <= $review->rating ? 'currentColor' : 'none' }}"
                  class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600' }}"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.286 3.948a1 1 0 00.95.69h4.148c.969 0 1.371 1.24.588 1.81l-3.36 2.44a1 1 0 00-.364 1.118l1.286 3.948c.3.921-.755 1.688-1.54 1.118l-3.36-2.44a1 1 0 00-1.176 0l-3.36 2.44c-.785.57-1.84-.197-1.54-1.118l1.286-3.948a1 1 0 00-.364-1.118l-3.36-2.44c-.783-.57-.38-1.81.588-1.81h4.148a1 1 0 00.95-.69l1.286-3.948z"/>
                </svg>
              @endfor
            </div>
          </a>
          <p class="text-sm text-gray-600 dark:text-gray-300">{{ $review->comment ?? 'No comment.' }}</p>
          <form action="{{ route('shop.reviews.destroy', $review) }}" method="POST">
            @csrf
            @method('DELETE')
            <button class="text-xs text-red-600 hover:underline mt-1">Delete</button>
          </form>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection