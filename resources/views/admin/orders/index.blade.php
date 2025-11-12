@extends('layouts.app')

@section('title', 'Orders')

@section('content')
<div 
  x-data="{ isModalOpen: false, title: '', deleteUrl: '' }"
  x-cloak
>
  <!-- Breadcrumb -->
  <nav class="mb-6 text-sm text-gray-500">
    <ol class="flex items-center space-x-2">
      <li><a href="{{ route('dashboard.index') }}" class="hover:underline">Dashboard</a></li>
      <li>/</li>
      <li class="text-gray-700 dark:text-gray-300">Orders</li>
    </ol>
  </nav>

  <!-- Flash Messages -->
  @if (session('success'))
    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700 dark:border-green-700/40 dark:bg-green-900/30 dark:text-green-300">
      <div class="flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span>{{ session('success') }}</span>
      </div>
    </div>
  @endif

  @if ($errors->any())
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700 dark:border-red-700/40 dark:bg-red-900/30 dark:text-red-300">
      <ul class="space-y-1">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- Filters -->
  <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3 mb-6">
    <form method="GET" class="flex flex-wrap items-center gap-2 w-full lg:w-auto">
      <input type="text" 
        name="search" 
        value="{{ $filters['search'] ?? '' }}" 
        placeholder="Search order or customer..." 
        class="border border-gray-300 rounded-lg px-3 py-2 w-full sm:w-64 bg-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      >

      <select name="status" class="select2 rounded-lg border border-gray-300 px-3 py-2 w-[150px]">
        <option value="">All Status</option>
        @foreach ($statuses as $status)
          <option value="{{ $status->value }}" @selected(($filters['status'] ?? '') === $status->value)>
            {{ $status->label() }}
          </option>
        @endforeach
      </select>

      <select name="payment_status" class="select2 rounded-lg border border-gray-300 px-3 py-2 w-[150px]">
        <option value="">All Payment</option>
        @foreach(['unpaid', 'paid', 'failed'] as $ps)
          <option value="{{ $ps }}" @selected(($filters['payment_status'] ?? '') === $ps)>
            {{ ucfirst($ps) }}
          </option>
        @endforeach
      </select>

      <select name="payment_method" class="select2 rounded-lg border border-gray-300 px-3 py-2 w-[160px]">
        <option value="">All Methods</option>
        @foreach(['bank_transfer', 'gopay', 'qris', 'credit_card'] as $method)
          <option value="{{ $method }}" @selected(($filters['payment_method'] ?? '') === $method)>
            {{ ucwords(str_replace('_', ' ', $method)) }}
          </option>
        @endforeach
      </select>

      <div class="flex gap-3">
        <input type="date" 
          name="date_from" 
          value="{{ $filters['date_from'] ?? '' }}" 
          class="border border-gray-300 rounded-lg px-3 py-2 w-40"
        >
        <input type="date" 
          name="date_to" 
          value="{{ $filters['date_to'] ?? '' }}" 
          class="border border-gray-300 rounded-lg px-3 py-2 w-40"
        >
      </div>

      <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition whitespace-nowrap">
        Filter
      </button>
    </form>

    @if (auth()->user()?->admin)
      <a href="{{ route('orders.create') }}" 
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition whitespace-nowrap w-full sm:w-auto text-center">
        + Add Order
      </a>
    @endif
  </div>

  <div class="flex justify-end mb-4">
    <a href="{{ route('orders.export', request()->query()) }}" 
      class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition whitespace-nowrap">
      Export Excel
    </a>
  </div>
  <!-- Table -->
  <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
    <div class="max-w-full overflow-x-auto">
      <table class="min-w-full text-left text-sm">
        <thead class="border-b border-gray-100 bg-gray-50">
          <tr>
            <th class="px-5 py-3 font-medium text-gray-600">Code</th>
            <th class="px-5 py-3 font-medium text-gray-600">Customer</th>
            <th class="px-5 py-3 font-medium text-gray-600">Total</th>
            <th class="px-5 py-3 font-medium text-gray-600">Shipping</th>
            <th class="px-5 py-3 font-medium text-gray-600">Grand Total</th>
            <th class="px-5 py-3 font-medium text-gray-600">Payment</th>
            <th class="px-5 py-3 font-medium text-gray-600">Status</th>
            @if (auth()->user()?->admin)
              <th class="px-5 py-3 font-medium text-gray-600 text-right">Actions</th>
            @endif
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @forelse ($orders as $order)
            <tr onclick="window.location='{{ route('orders.show', $order) }}'"
              class="cursor-pointer hover:bg-gray-50 transition-colors">
              <td class="px-5 py-3 font-semibold text-gray-800">{{ $order->code }}</td>
              <td class="px-5 py-3 text-gray-700">{{ $order->customer->name ?? '-' }}</td>
              <td class="px-5 py-3 text-gray-700">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
              <td class="px-5 py-3 text-gray-700">Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
              <td class="px-5 py-3 font-semibold text-gray-900">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</td>
              <td class="px-5 py-3 text-gray-700 space-y-1">
                <span class="block text-xs font-semibold">{{ strtoupper($order->payment_status) }}</span>
                <span class="block text-xs text-gray-500">{{ strtoupper($order->payment_method ?? '-') }}</span>
              </td>
              <td class="px-5 py-3">
                @php
                  $color = match($order->status) {
                    \App\Enum\OrderStatus::PENDING => 'bg-yellow-100 text-yellow-700',
                    \App\Enum\OrderStatus::PROCESSING => 'bg-blue-100 text-blue-700',
                    \App\Enum\OrderStatus::CANCELED => 'bg-red-100 text-red-700',
                    \App\Enum\OrderStatus::SHIPPED => 'bg-indigo-100 text-indigo-700',
                    \App\Enum\OrderStatus::DELIVERED => 'bg-green-100 text-green-700',
                    default => 'bg-gray-100 text-gray-600',
                  };
                @endphp
                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $color }}">
                  {{ $order->status }}
                </span>
              </td>
              @if (auth()->user()?->admin)
                <td class="px-5 py-3 text-right">
                  <a href="{{ route('orders.edit', $order) }}" onclick="event.stopPropagation()" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                  <button 
                    @click.prevent="
                      event.stopPropagation();
                      title = '{{ $order->code }}';
                      deleteUrl = '{{ route('orders.destroy', $order) }}';
                      isModalOpen = true
                    "
                    class="text-red-600 hover:text-red-700 ml-3 font-medium">
                    Delete
                  </button>
                </td>
              @endif
            </tr>
          @empty
            <tr>
              <td colspan="8" class="px-5 py-6 text-center text-gray-500">
                No orders found.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="p-4">
      {{ $orders->appends(request()->query())->links() }}
    </div>
  </div>

  <x-modal.modal-delete />
</div>
@endsection

@push('js')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    $('.select2').select2({
      width: 'resolve',
      minimumResultsForSearch: Infinity,
      dropdownAutoWidth: true,
    });
  });
</script>
@endpush