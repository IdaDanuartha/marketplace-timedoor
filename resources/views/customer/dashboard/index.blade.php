@extends('layouts.app')

@section('title', 'Customer Dashboard')

@section('content')
<div class="space-y-8" x-data="{ isModalOpen: false, deleteUrl: '', title: '' }">

  <!-- Cancel Modal -->
  <div
    x-show="isModalOpen"
    x-cloak
    class="fixed inset-0 flex items-center justify-center p-5 z-[99999]"
  >
    <!-- Backdrop -->
    <div @click="isModalOpen = false" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

    <!-- Modal -->
    <div
      @click.outside="isModalOpen = false"
      class="relative w-full max-w-md rounded-2xl bg-white dark:bg-gray-900 shadow-lg p-6"
    >
      <!-- Header -->
      <div class="flex items-center justify-between mb-4">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
          Cancel <span x-text="title" class="capitalize"></span>
        </h2>
        <button 
          @click="isModalOpen = false"
          class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
        >
          ✕
        </button>
      </div>

      <!-- Body -->
      <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
        Are you sure you want to cancel 
        <b class="text-gray-800 dark:text-gray-200 lowercase" x-text="title"></b>?<br>
        This action cannot be undone.
      </p>

      <!-- Actions -->
      <div class="flex justify-end gap-3">
        <button 
          @click="isModalOpen = false"
          class="px-4 py-2 border border-gray-300 dark:border-gray-700 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 transition"
        >
          Back
        </button>

        <form :action="deleteUrl" method="POST">
          @csrf
          @method('PATCH')
          <button 
            type="submit"
            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-sm rounded-lg text-white transition"
          >
            Confirm Cancel
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- METRICS -->
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @foreach ($metrics as $key => $metric)
      <div class="p-5 rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900 flex flex-col justify-between">
        <div class="flex items-center justify-between">
          <h3 class="text-sm text-gray-500 dark:text-gray-400 font-medium">{{ $metric['label'] }}</h3>
          @if ($key === 'pending')
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          @elseif ($key === 'processing')
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v6h6M20 20v-6h-6m1.42-9.42A9 9 0 0112 3a9 9 0 019 9m-1.42 5.42A9 9 0 0112 21a9 9 0 01-9-9" />
            </svg>
          @elseif ($key === 'shipped')
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V5a1 1 0 011-1h7l4 5v8a1 1 0 01-1 1h-1m-2 0a1 1 0 11-2 0m-8 0a1 1 0 102 0m-2 0H5a1 1 0 01-1-1v-3h16" />
            </svg>
          @elseif ($key === 'delivered')
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4m6 2a9 9 0 11-18 0a9 9 0 0118 0z" />
            </svg>
          @endif
        </div>
        <p class="text-3xl font-bold text-gray-800 dark:text-white mt-2">{{ $metric['count'] }}</p>
      </div>
    @endforeach
  </div>

  <!-- ORDER HISTORY -->
  <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Recent Orders</h2>

    @if ($orderHistory->isEmpty())
      <p class="text-gray-500 text-sm">No orders found.</p>
    @else
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left border-separate border-spacing-y-2">
          <thead class="text-gray-600 dark:text-gray-400 uppercase text-xs">
            <tr>
              <th class="py-2 px-3">Order</th>
              <th class="py-2 px-3">Items</th>
              <th class="py-2 px-3">Total</th>
              <th class="py-2 px-3">Status</th>
              <th class="py-2 px-3">Date</th>
              <th class="py-2 px-3 text-right">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($orderHistory as $order)
              <tr class="bg-gray-50 dark:bg-gray-800/50 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                <td class="py-2 px-3 font-medium text-gray-800 dark:text-white">
                  <a href="{{ route('shop.orders.show', $order) }}" class="hover:text-blue-600">
                    {{ $order->code }}
                  </a>
                </td>
                <td class="py-2 px-3 text-gray-600 dark:text-gray-300">{{ $order->items->sum('qty') }}</td>
                <td class="py-2 px-3 text-gray-700 dark:text-gray-200">
                  Rp {{ number_format($order->grand_total ?? $order->total_price, 0, ',', '.') }}
                </td>
                <td class="py-2 px-3">
                  <span class="px-2 py-1 rounded-full text-xs font-medium
                    @class([
                      'bg-yellow-100 text-yellow-700' => $order->status->value === 'PENDING',
                      'bg-blue-100 text-blue-700' => $order->status->value === 'PROCESSING',
                      'bg-purple-100 text-purple-700' => $order->status->value === 'SHIPPED',
                      'bg-green-100 text-green-700' => $order->status->value === 'DELIVERED',
                      'bg-red-100 text-red-700' => $order->status->value === 'CANCELED',
                    ])">
                    {{ $order->status->label() }}
                  </span>
                </td>
                <td class="py-2 px-3 text-gray-600 dark:text-gray-300">
                  {{ $order->created_at->format('d M Y') }}
                </td>
                <td class="py-2 px-3 text-right flex justify-end gap-2">
                  <a href="{{ route('shop.orders.show', $order) }}"
                     class="text-xs px-3 py-1.5 rounded-lg border text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800">
                    View
                  </a>

                  @if($order->status->value === 'PENDING' && strtoupper($order->payment_status ?? '') === 'UNPAID')
                    <a href="{{ route('shop.orders.pay', $order) }}"
                       class="text-xs px-3 py-1.5 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                      Pay Now
                    </a>
                  @endif

                  @if($order->status->value === 'PENDING')
                    <button
                      @click="isModalOpen = true; deleteUrl = '{{ route('shop.orders.cancel', $order) }}'; title = '{{ $order->code }}';"
                      type="button"
                      class="text-xs px-3 py-1.5 rounded-lg bg-red-600 text-white hover:bg-red-700">
                      Cancel
                    </button>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>

  <!-- ORDER LOG ACTIVITY -->
  {{-- <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Order Activity Log</h2>
    @if ($orderLogs->isEmpty())
      <p class="text-gray-500 text-sm">No recent activities.</p>
    @else
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left border-separate border-spacing-y-2">
          <thead class="text-gray-600 dark:text-gray-400 uppercase text-xs">
            <tr>
              <th class="py-2 px-3">Order</th>
              <th class="py-2 px-3">Product</th>
              <th class="py-2 px-3">Qty</th>
              <th class="py-2 px-3">Status</th>
              <th class="py-2 px-3">Updated</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($orderLogs as $log)
              <tr class="bg-gray-50 dark:bg-gray-800/50 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                <td class="py-2 px-3 font-medium text-gray-800 dark:text-white">{{ $log['order_code'] }}</td>
                <td class="py-2 px-3 text-gray-600 dark:text-gray-300">{{ $log['product'] }}</td>
                <td class="py-2 px-3 text-gray-600 dark:text-gray-300">{{ $log['qty'] }}</td>
                <td class="py-2 px-3">
                  <span class="px-2 py-1 rounded-full text-xs font-medium
                    @class([
                      'bg-yellow-100 text-yellow-700' => $log['status'] === 'PENDING',
                      'bg-blue-100 text-blue-700' => $log['status'] === 'PROCESSING',
                      'bg-purple-100 text-purple-700' => $log['status'] === 'SHIPPED',
                      'bg-green-100 text-green-700' => $log['status'] === 'DELIVERED',
                      'bg-red-100 text-red-700' => $log['status'] === 'CANCELED',
                    ])">
                    {{ $log['status'] ?? '-' }}
                  </span>
                </td>
                <td class="py-2 px-3 text-gray-600 dark:text-gray-300">{{ $log['updated_at'] }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div> --}}
</div>
@endsection