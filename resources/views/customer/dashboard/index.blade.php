@extends('layouts.app')

@section('title', 'Customer Dashboard')

@section('content')
<div class="space-y-8">

  <!-- Metrics: Order Status -->
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    @foreach ($metrics as $key => $metric)
      <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
        <h3 class="text-sm text-gray-500 dark:text-gray-400 font-medium">{{ $metric['label'] }}</h3>
        <p class="text-2xl font-bold text-gray-800 dark:text-white mt-1">{{ $metric['count'] }}</p>
      </div>
    @endforeach
  </div>

  <!-- Order History -->
  <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Order History</h2>
    @if ($orderHistory->isEmpty())
      <p class="text-gray-500 text-sm">No orders found.</p>
    @else
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left">
          <thead class="border-b border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400">
            <tr>
              <th class="py-2 px-3">Order Code</th>
              <th class="py-2 px-3">Total Items</th>
              <th class="py-2 px-3">Total Price</th>
              <th class="py-2 px-3">Status</th>
              <th class="py-2 px-3">Date</th>
            </tr>
          </thead>
          <tbody class="text-gray-700 dark:text-gray-300">
            @foreach ($orderHistory as $order)
              <tr class="border-b border-gray-100 dark:border-gray-800">
                <td class="py-2 px-3 font-medium">{{ $order->code }}</td>
                <td class="py-2 px-3">{{ $order->items->sum('qty') }}</td>
                <td class="py-2 px-3">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                <td class="py-2 px-3">
                  <span class="px-2 py-1 rounded text-xs font-medium
                    @if($order->status === 'pending') bg-yellow-100 text-yellow-700
                    @elseif($order->status === 'processing') bg-blue-100 text-blue-700
                    @elseif($order->status === 'shipped') bg-purple-100 text-purple-700
                    @elseif($order->status === 'delivered') bg-green-100 text-green-700
                    @endif">
                    {{ ucfirst($order->status) }}
                  </span>
                </td>
                <td class="py-2 px-3">{{ $order->created_at->format('Y-m-d') }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>

  <!-- Order Log Activity -->
  <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-6">
    <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Order Activity Log</h2>
    @if ($orderLogs->isEmpty())
      <p class="text-gray-500 text-sm">No recent activities.</p>
    @else
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm text-left">
          <thead class="border-b border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400">
            <tr>
              <th class="py-2 px-3">Order Code</th>
              <th class="py-2 px-3">Product</th>
              <th class="py-2 px-3">Qty</th>
              <th class="py-2 px-3">Status</th>
              <th class="py-2 px-3">Updated At</th>
            </tr>
          </thead>
          <tbody class="text-gray-700 dark:text-gray-300">
            @foreach ($orderLogs as $log)
              <tr class="border-b border-gray-100 dark:border-gray-800">
                <td class="py-2 px-3">{{ $log['order_code'] }}</td>
                <td class="py-2 px-3">{{ $log['product'] }}</td>
                <td class="py-2 px-3">{{ $log['qty'] }}</td>
                <td class="py-2 px-3 capitalize">{{ $log['status'] }}</td>
                <td class="py-2 px-3">{{ $log['updated_at'] }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    @endif
  </div>
</div>
@endsection