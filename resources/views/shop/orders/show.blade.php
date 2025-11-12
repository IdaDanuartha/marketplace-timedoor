@extends('layouts.app')
@section('title', 'Order Details')

@section('content')
<div class="max-w-5xl mx-auto py-8 space-y-6">
  <div class="flex justify-between items-center">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Order #{{ $order->code }}</h1>
    <a href="{{ route('shop.orders.index') }}" class="text-blue-600 text-sm hover:underline">← Back to Orders</a>
  </div>

  <div class="p-6 border rounded-lg bg-white dark:bg-gray-900 space-y-5">
    <div class="flex justify-between items-center">
      <div>
        <span class="block text-sm text-gray-500 dark:text-gray-400">Order Date:</span>
        <span class="font-semibold text-gray-800 dark:text-white">{{ $order->created_at->format('d M Y, H:i') }}</span>
      </div>

      <div class="text-right">
        <span class="block text-sm text-gray-500 dark:text-gray-400">Status:</span>
        <span class="font-semibold text-gray-800 dark:text-white">{{ $order->status->label() }}</span>
      </div>
    </div>

    <hr class="border-gray-300 dark:border-gray-700">

    {{-- Items --}}
    <div class="space-y-3">
      @foreach($order->items as $item)
        <div class="flex justify-between text-sm text-gray-700 dark:text-gray-300">
          <span>{{ $item->product->name }} × {{ $item->qty }}</span>
          <span>Rp {{ number_format($item->qty * $item->price, 0, ',', '.') }}</span>
        </div>
      @endforeach
    </div>

    <hr class="border-gray-300 dark:border-gray-700">

    {{-- Totals --}}
    <div class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
      <div class="flex justify-between"><span>Subtotal:</span><span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></div>
      <div class="flex justify-between"><span>Shipping:</span><span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span></div>
      <div class="flex justify-between font-semibold text-gray-900 dark:text-white text-lg">
        <span>Total:</span><span>Rp {{ number_format($order->grand_total, 0, ',', '.') }}</span>
      </div>
    </div>

    <hr class="border-gray-300 dark:border-gray-700">

    {{-- Payment Status --}}
    <div class="flex justify-between items-center">
      <div>
        <span class="block text-sm text-gray-500 dark:text-gray-400">Payment Method:</span>
        <span class="font-medium text-gray-800 dark:text-white">{{ strtoupper($order->payment_method ?? '-') }}</span>
      </div>
      <div>
        <span class="block text-sm text-gray-500 dark:text-gray-400">Payment Status:</span>
        <span class="font-medium text-gray-800 dark:text-white">{{ strtoupper($order->payment_status ?? 'UNPAID') }}</span>
      </div>
    </div>

    {{-- Actions --}}
    <div class="flex justify-end gap-3 pt-4">
      @if($order->status->value === 'PENDING' && $order->payment_status === 'UNPAID')
        <a href="{{ route('shop.orders.pay', $order) }}"
           class="px-5 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium">
          Pay Now
        </a>
        <form action="{{ route('shop.orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Cancel this order?')">
          @csrf
          @method('PATCH')
          <button type="submit" class="px-5 py-2.5 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium">
            Cancel Order
          </button>
        </form>
      @endif
    </div>
  </div>
</div>
@endsection