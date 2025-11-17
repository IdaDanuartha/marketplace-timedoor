<div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:bg-transparent dark:border-white/20 shadow-sm">
    <div class="max-w-full overflow-x-auto">
      <table class="min-w-full text-left text-sm">
        <thead class="border-b border-gray-100 bg-gray-50 dark:border-white/20 dark:bg-white/5">
          <tr>
            @if (auth()->user()?->admin)
              <th class="px-5 py-3 w-12">
                <input 
                  type="checkbox" 
                  x-model="selectAll"
                  @change="toggleAll()"
                  class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                >
              </th>
            @endif
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-white">Code</th>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-white">Customer</th>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-white">Total</th>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-white">Shipping</th>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-white">Grand Total</th>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-white">Payment</th>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-white">Status</th>
            @if (auth()->user()?->admin)
              <th class="px-5 py-3 font-medium text-gray-600 dark:text-white text-right">Actions</th>
            @endif
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
          @forelse ($orders as $order)
            <tr class="hover:bg-gray-50 transition-colors">
              @if (auth()->user()?->admin)
                <td class="px-5 py-3">
                  <input 
                    type="checkbox" 
                    value="{{ $order->id }}"
                    x-model="selectedOrders"
                    @change="updateSelectAll()"
                    class="order-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                    onclick="event.stopPropagation()"
                  >
                </td>
              @endif
              <td class="px-5 py-3 font-semibold text-gray-800 cursor-pointer" onclick="window.location='{{ route('orders.show', $order) }}'">
                {{ $order->code }}
              </td>
              <td class="px-5 py-3 text-gray-700 cursor-pointer" onclick="window.location='{{ route('orders.show', $order) }}'">
                {{ $order->customer->name ?? '-' }}
              </td>
              <td class="px-5 py-3 text-gray-700 cursor-pointer" onclick="window.location='{{ route('orders.show', $order) }}'">
                Rp{{ number_format($order->total_price, 0, ',', '.') }}
              </td>
              <td class="px-5 py-3 text-gray-700 cursor-pointer" onclick="window.location='{{ route('orders.show', $order) }}'">
                Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}
              </td>
              <td class="px-5 py-3 font-semibold text-gray-900 cursor-pointer" onclick="window.location='{{ route('orders.show', $order) }}'">
                Rp{{ number_format($order->grand_total, 0, ',', '.') }}
              </td>
              <td class="px-5 py-3 text-gray-700 space-y-1 cursor-pointer" onclick="window.location='{{ route('orders.show', $order) }}'">
                <span class="block text-xs font-semibold">{{ strtoupper($order->payment_status) }}</span>
                <span class="block text-xs text-gray-500">{{ strtoupper($order->payment_method ?? '-') }}</span>
              </td>
              <td class="px-5 py-3 cursor-pointer" onclick="window.location='{{ route('orders.show', $order) }}'">
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
                  <a href="{{ route('orders.edit', $order) }}" 
                    onclick="event.stopPropagation()" 
                    class="text-blue-600 hover:text-blue-800 font-medium mr-3">
                    Edit
                  </a>
                  <button 
                    @click.prevent="
                      event.stopPropagation();
                      title = '{{ $order->code }}';
                      deleteUrl = '{{ route('orders.destroy', $order) }}';
                      isModalOpen = true
                    "
                    class="text-red-600 hover:text-red-700 font-medium">
                    Delete
                  </button>
                </td>
              @endif
            </tr>
          @empty
            <tr>
              <td colspan="9" class="px-5 py-6 text-center text-gray-500">
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