@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
<div 
  x-data="{ isModalOpen: false, title: '', deleteUrl: '' }"
  x-cloak
>
  <div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12">
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">

        {{-- Header --}}
        <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-gray-100 dark:border-gray-800">
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Product Details</h3>
        </div>

        {{-- Body --}}
        <div class="p-6 space-y-8">
          {{-- Product Info --}}
          <div class="flex flex-col md:flex-row items-start gap-6">
            {{-- Image --}}
            <div class="w-40 h-40 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden bg-gray-50 dark:bg-gray-900 flex items-center justify-center">
              @if ($product->image_path)
                <img src="{{ profile_image($product->image_path ?? null) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
              @else
                <span class="text-gray-400 text-sm">No Image</span>
              @endif
            </div>

            {{-- Basic Info --}}
            <div class="flex-1">
              <h2 class="text-2xl font-semibold text-gray-800 dark:text-white">{{ $product->name }}</h2>

              <div class="mt-4 flex items-center gap-2">
                @php
                  $color = match($product->status) {
                    \App\Enum\ProductStatus::ACTIVE => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
                    \App\Enum\ProductStatus::DRAFT => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
                    \App\Enum\ProductStatus::OUT_OF_STOCK => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
                  };
                @endphp
                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $color }}">
                  {{ $product->status->label() }}
                </span>
                <span class="text-gray-700 dark:text-gray-300 font-medium">
                  Rp{{ number_format($product->price, 0, ',', '.') }}
                </span>
              </div>

              <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                Stock: <span class="font-medium text-gray-800 dark:text-gray-200">{{ $product->stock }}</span>
              </p>
            </div>
          </div>

          {{-- Category & Vendor Info --}}
          <div class="grid sm:grid-cols-2 gap-6">
            {{-- Category --}}
            <div class="rounded-xl border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/40 p-5">
              <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Category</h4>
              @if ($product->category)
                <p class="text-gray-800 dark:text-gray-200">{{ $product->category->name }}</p>
                <a href="{{ route('categories.show', $product->category) }}" 
                   class="text-blue-600 hover:underline text-sm">View Category →</a>
              @else
                <p class="text-gray-500 dark:text-gray-400 text-sm">No category assigned.</p>
              @endif
            </div>

            {{-- Vendor --}}
            <div class="rounded-xl border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/40 p-5">
              <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Vendor</h4>
              @if ($product->vendor)
                <p class="text-gray-800 dark:text-gray-200">{{ $product->vendor->name }}</p>
                <a href="{{ route('vendors.show', $product->vendor) }}" 
                   class="text-blue-600 hover:underline text-sm">View Vendor →</a>
              @else
                <p class="text-gray-500 dark:text-gray-400 text-sm">No vendor assigned.</p>
              @endif
            </div>
          </div>

          {{-- Description --}}
          <div class="rounded-xl border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/40 p-5">
            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Description</h4>
            <div class="prose dark:prose-invert max-w-none">
              {!! $product->description ?: '<p class="text-gray-500 dark:text-gray-400 text-sm">No description available.</p>' !!}
            </div>
          </div>

          {{-- Actions --}}
          <div class="flex flex-wrap justify-between items-center pt-6 border-t border-gray-100 dark:border-gray-800">
            <a href="{{ route('products.index') }}" 
               class="text-sm text-gray-500 hover:underline">← Back to Products</a>

            <div class="flex items-center gap-3">
              <a href="{{ route('products.edit', $product) }}" 
                 class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                Edit
              </a>
              <button 
                @click.prevent="
                  title = '{{ $product->name }}';
                  deleteUrl = '{{ route('products.destroy', $product) }}';
                  isModalOpen = true;
                "
                class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition">
                Delete
              </button>
            </div>
          </div>
        </div>

        {{-- Delete Modal --}}
        <x-modal.modal-delete />
      </div>
    </div>
  </div>
</div>
@endsection