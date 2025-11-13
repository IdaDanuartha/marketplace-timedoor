@extends('layouts.app')
@section('title', 'My Orders')

@section('content')
<div class="max-w-6xl mx-auto py-8 space-y-6" x-data="{ isModalOpen: false, deleteUrl: '', title: '' }">
  <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">My Orders</h1>

  @if($orders->isEmpty())
    <div class="p-6 text-center bg-white dark:bg-gray-900 border rounded-lg text-gray-600 dark:text-gray-300">
      You have no orders yet.
      <a href="{{ route('shop.products.index') }}" class="text-blue-600 hover:underline">Start shopping</a>
    </div>
  @else
    <div class="space-y-5">
      @foreach($orders as $order)
        <div class="border dark:border-white/10 rounded-lg bg-white dark:bg-gray-900 p-5 hover:shadow-md transition">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
              <h2 class="font-semibold text-gray-800 dark:text-white">Order #{{ $order->code }}</h2>
              <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $order->created_at->format('d M Y, H:i') }}
              </p>
            </div>

            <div class="flex items-center gap-2">
                @php
                $color = match($order->status) {
                    \App\Enum\OrderStatus::PENDING => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
                    \App\Enum\OrderStatus::PROCESSING => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
                    \App\Enum\OrderStatus::SHIPPED => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300',
                    \App\Enum\OrderStatus::DELIVERED => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
                    \App\Enum\OrderStatus::CANCELED => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
                };
                @endphp
                <span class="px-2 py-1 rounded-full text-xs font-medium text-nowrap {{ $color }}">
                {{ $order->status->label() }}
                </span>
              @if ($order->payment_status !== 'CANCELED')
                <span class="px-2 py-1 text-xs rounded-full uppercase {{ $order->payment_status === 'PAID' || $order->payment_status === 'paid' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                  {{ $order->payment_status }}
                </span>
              @endif
            </div>
          </div>

          <hr class="my-3 border-gray-200 dark:border-gray-700">

          {{-- Item summary --}}
          <div class="space-y-3">
            @foreach($order->items as $item)
              <div class="flex justify-between items-center text-sm text-gray-700 dark:text-gray-300">
                <span>{{ $item->product->name }} × {{ $item->qty }}</span>
                <span>Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}</span>
              </div>
            @endforeach
          </div>

          <div class="flex justify-between items-center mt-4 font-semibold text-gray-800 dark:text-white">
            <span>Total:</span>
            <span>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
          </div>

          {{-- Actions --}}
          <div class="flex justify-end gap-3 mt-4">
            <a href="{{ route('shop.orders.show', $order->code) }}" 
               class="text-sm px-4 py-2 rounded-lg border text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
              View Details
            </a>

            @if($order->status->value === 'PENDING')
              <button @click="isModalOpen = true; deleteUrl = '{{ route('shop.orders.cancel', $order) }}'; title = '{{ $order->code }}';" class="text-sm px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                Cancel
              </button>

              @if($order->payment_status === 'UNPAID')
                <a href="{{ route('shop.orders.pay', $order) }}" 
                   class="text-sm px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                  Pay Now
                </a>
              @endif
            @endif
          </div>
        </div>
      @endforeach
    </div>
  @endif

  <x-modal.cancel-order-modal />
</div>
@endsection