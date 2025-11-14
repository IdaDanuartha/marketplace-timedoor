@extends('layouts.app')
@section('title', 'Order Details')

@section('content')
<nav class="text-sm text-gray-500">
  <ol class="flex items-center space-x-2">
    <li><a href="{{ route('dashboard.index') }}" class="hover:underline">Dashboard</a></li>
    <li>/</li>
    <li><a href="{{ route('shop.orders.index') }}" class="hover:underline">Orders</a></li>
    <li>/</li>
    <li class="text-gray-700 dark:text-gray-300">Detail</li>
  </ol>
</nav>

{{-- Alerts --}}
@if (session('success'))
  <div class="p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg mb-4">
    {{ session('success') }}
  </div>
@endif
@if ($errors->any())
  <div class="p-3 bg-red-100 border border-red-300 text-red-800 rounded-lg mb-4">
    {{ $errors->first() }}
  </div>
@endif

<div class="max-w-6xl mx-auto py-8 space-y-6" x-data="{ isModalOpen: false, deleteUrl: '', title: '' }">

  {{-- Header --}}
  <div class="flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">
      Order #{{ $order->code }}
    </h1>
    <a href="{{ route('shop.orders.index') }}" 
       class="text-blue-600 text-sm hover:underline">← Back to Orders</a>
  </div>

  {{-- Main Card --}}
  <div class="p-6 border rounded-lg bg-white dark:bg-gray-900 space-y-6 dark:border-white/10">

    {{-- Top Info --}}
    <div class="flex flex-col md:flex-row md:justify-between gap-4">

      {{-- Order Date --}}
      <div>
        <p class="text-sm text-gray-500 dark:text-gray-400">Order Date</p>
        <p class="font-semibold text-gray-800 dark:text-white">
          {{ $order->created_at->format('d M Y, H:i') }}
        </p>
      </div>

      {{-- Status --}}
      <div class="text-left md:text-right">
        <p class="text-sm text-gray-500 dark:text-gray-400">Order Status</p>
        @php
          $color = match($order->status->value ?? '') {
              'PENDING' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
              'PROCESSING' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
              'SHIPPED' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300',
              'DELIVERED' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
              'CANCELED' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
              default => 'bg-gray-200 text-gray-700 dark:bg-gray-800 dark:text-gray-300'
          };
        @endphp
        <span class="px-3 py-1 text-xs rounded-full font-medium {{ $color }}">
          {{ $order->status->label() }}
        </span>
      </div>
    </div>

    <hr class="border-gray-300 dark:border-gray-700">

    {{-- Shipping Info --}}
    <div class="space-y-1">
      <p class="text-sm text-gray-500 dark:text-gray-400">Shipping Method</p>
      <p class="font-medium text-gray-800 dark:text-white">
        {{ $order->shipping_service ?? '-' }}
      </p>
    </div>

    <hr class="border-gray-300 dark:border-gray-700">

    {{-- Items List --}}
    <div class="space-y-4">
      <h2 class="font-semibold text-gray-800 dark:text-white">Order Items</h2>

      <div class="space-y-3">
        @foreach($order->items as $item)
          <div class="flex justify-between items-center border rounded-lg p-4 bg-gray-50 dark:bg-gray-800/40">
            <div>
              <p class="font-medium text-gray-800 dark:text-white">
                {{ $item->product->name }}
              </p>
              <p class="text-sm text-gray-600 dark:text-gray-300">
                Qty: {{ $item->qty }}
              </p>
            </div>

            <p class="font-semibold text-gray-800 dark:text-white">
              Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}
            </p>
          </div>
        @endforeach
      </div>
    </div>

    <hr class="border-gray-300 dark:border-gray-700">

    {{-- Totals --}}
    <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
      <div class="flex justify-between">
        <span>Subtotal</span>
        <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
      </div>
      <div class="flex justify-between">
        <span>Shipping</span>
        <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
      </div>
      <div class="flex justify-between font-semibold text-lg text-gray-900 dark:text-white">
        <span>Total</span>
        <span>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
      </div>
    </div>

    <hr class="border-gray-300 dark:border-gray-700">

    {{-- Payment Info --}}
    <div class="grid sm:grid-cols-2 gap-4">
      
      <div>
        <p class="text-sm text-gray-500 dark:text-gray-400">Payment Method</p>
        <p class="font-medium text-gray-800 dark:text-white">
          {{ strtoupper($order->payment_method ?? '-') }}
        </p>
      </div>

      <div>
        <p class="text-sm text-gray-500 dark:text-gray-400">Payment Status</p>

        @php
          $payColor = $order->payment_status === 'PAID'
              ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300'
              : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300';
        @endphp

        <span class="px-3 py-1 text-xs rounded-full font-medium {{ $payColor }}">
          {{ strtoupper($order->payment_status ?? 'UNPAID') }}
        </span>
      </div>

    </div>

    {{-- Actions --}}
    <div class="flex justify-end gap-3 pt-4">
      @if($order->status->value === 'PENDING' && $order->payment_status === 'UNPAID')
        <a href="{{ route('shop.orders.pay', $order) }}"
           class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">
          Pay Now
        </a>

        <button 
          @click="isModalOpen = true; deleteUrl = '{{ route('shop.orders.cancel', $order) }}'; title = '{{ $order->code }}';"
          class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">
          Cancel Order
        </button>
      @endif
    </div>

  </div>

  <x-modal.cancel-order-modal />
</div>
@endsection