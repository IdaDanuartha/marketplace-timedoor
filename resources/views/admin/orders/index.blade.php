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
      <div class="flex items-start gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 5a7 7 0 100 14 7 7 0 000-14z" />
        </svg>
        <ul class="space-y-1">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    </div>
  @endif

  <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-3">
    <form method="GET" class="flex sm:flex-nowrap flex-wrap items-center gap-2">
      <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search order..."
        class="border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 w-64 bg-white dark:bg-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

      <select name="status" class="select2 w-20">
        <option value="">All Status</option>
        @foreach ($statuses as $status)
          <option value="{{ $status->name }}" {{ ($filters['status'] ?? '') === $status->name ? 'selected' : '' }}>
            {{ $status->label() }}
          </option>
        @endforeach
      </select>

      <button class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
        Filter
      </button>
    </form>

    @if (auth()->user()?->admin)
      <a href="{{ route('orders.create') }}" 
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
        + Add Order
      </a>
    @endif
  </div>

  <!-- Table -->
  <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900/50">
    <div class="max-w-full overflow-x-auto">
      <table class="min-w-full text-left text-sm">
        <thead class="border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/30">
          <tr>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">
              <a href="{{ route('orders.index', [
                'sort_by' => 'code',
                'sort_dir' => ($filters['sort_by'] ?? '') === 'code' && ($filters['sort_dir'] ?? '') === 'asc' ? 'desc' : 'asc',
                'search' => $filters['search'] ?? '',
              ]) }}" class="flex items-center gap-1 hover:underline">
                Code
                @if(($filters['sort_by'] ?? '') === 'code')
                  @if(($filters['sort_dir'] ?? '') === 'asc')
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                    </svg>
                  @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                  @endif
                @endif
              </a>
            </th>

            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Customer</th>

            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">
              <a href="{{ route('orders.index', [
                'sort_by' => 'total_price',
                'sort_dir' => ($filters['sort_by'] ?? '') === 'total_price' && ($filters['sort_dir'] ?? '') === 'asc' ? 'desc' : 'asc',
                'search' => $filters['search'] ?? '',
              ]) }}" class="flex items-center gap-1 hover:underline">
                Total
                @if(($filters['sort_by'] ?? '') === 'total_price')
                  @if(($filters['sort_dir'] ?? '') === 'asc')
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                    </svg>
                  @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                  @endif
                @endif
              </a>
            </th>

            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">
              <a href="{{ route('orders.index', [
                'sort_by' => 'shipping_cost',
                'sort_dir' => ($filters['sort_by'] ?? '') === 'shipping_cost' && ($filters['sort_dir'] ?? '') === 'asc' ? 'desc' : 'asc',
                'search' => $filters['search'] ?? '',
              ]) }}" class="flex items-center gap-1 hover:underline">
                Shipping
                @if(($filters['sort_by'] ?? '') === 'shipping_cost')
                  @if(($filters['sort_dir'] ?? '') === 'asc')
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                    </svg>
                  @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                  @endif
                @endif
              </a>
            </th>

            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">
              <a href="{{ route('orders.index', [
                'sort_by' => 'status',
                'sort_dir' => ($filters['sort_by'] ?? '') === 'status' && ($filters['sort_dir'] ?? '') === 'asc' ? 'desc' : 'asc',
                'search' => $filters['search'] ?? '',
              ]) }}" class="flex items-center gap-1 hover:underline">
                Status
                @if(($filters['sort_by'] ?? '') === 'status')
                  @if(($filters['sort_dir'] ?? '') === 'asc')
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                    </svg>
                  @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                  @endif
                @endif
              </a>
            </th>

            @if (auth()->user()?->admin)
              <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300 text-right">Actions</th>
            @endif
          </tr>
        </thead>

        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
          @forelse ($orders as $order)
            <tr
              onclick="window.location='{{ route('orders.show', $order) }}'"
              class="cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800/40 transition-colors"
            >
              <td class="px-5 py-3 font-semibold text-gray-800 dark:text-gray-100">{{ $order->code }}</td>
              <td class="px-5 py-3 text-gray-700 dark:text-gray-300">{{ $order->customer->name ?? '-' }}</td>
              <td class="px-5 py-3 text-gray-700 dark:text-gray-300">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
              <td class="px-5 py-3 text-gray-700 dark:text-gray-300">Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</td>
              <td class="px-5 py-3">
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
              </td>
              @if (auth()->user()?->admin)
                <td class="px-5 py-3 text-right">
                  <a href="{{ route('orders.edit', $order) }}" onclick="event.stopPropagation()"
                    class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-400 font-medium transition">
                    Edit
                  </a>
                  <button 
                    @click.prevent="
                      event.stopPropagation();
                      title = '{{ $order->code }}'; 
                      deleteUrl = '{{ route('orders.destroy', $order) }}'; 
                      isModalOpen = true
                    "
                    class="text-red-600 hover:text-red-700 dark:hover:text-red-400 ml-3 font-medium transition">
                    Delete
                  </button>
                </td>
              @endif
            </tr>
          @empty
            <tr>
              <td colspan="7" class="px-5 py-6 text-center text-gray-500 dark:text-gray-400">
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

  <!-- Delete Modal -->
  <x-modal.modal-delete />
</div>
@endsection

@push('js')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    $('.select2').select2({
      width: '100%',
      minimumResultsForSearch: 0,
    });
  });
</script>
@endpush