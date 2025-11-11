@extends('layouts.app')

@section('title', 'Order Detail')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6" x-data="{ isModalOpen: false, title: '', deleteUrl: '' }"
  x-cloak>
  <div class="col-span-12">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
      <div class="px-5 py-4 sm:px-6 sm:py-5 flex items-center justify-between">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
          Order Details — <span class="font-semibold text-blue-600">{{ $order->code }}</span>
        </h3>
        <a href="{{ route('orders.index') }}" class="text-sm text-blue-600 hover:underline">← Back</a>
      </div>

      <div class="border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800 space-y-8">
        {{-- Order Info --}}
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
          <div>
            <p class="text-gray-500 dark:text-gray-400">Customer</p>
            <p class="font-medium text-gray-800 dark:text-gray-100">
              {{ $order->customer->name ?? '-' }}
            </p>
          </div>

          <div class="mb-4">
              <label class="block text-sm font-medium mb-1">Order Status</label>
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
          </div>


          <div>
            <p class="text-gray-500 dark:text-gray-400">Date</p>
            <p class="font-medium text-gray-800 dark:text-gray-100">
              {{ $order->created_at->format('d M Y, H:i') }}
            </p>
          </div>

          <div>
            <p class="text-gray-500 dark:text-gray-400">Shipping Cost</p>
            <p class="font-medium text-gray-800 dark:text-gray-100">
              Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}
            </p>
          </div>

          <div>
            <p class="text-gray-500 dark:text-gray-400">Total Price</p>
            <p class="font-semibold text-gray-900 dark:text-gray-100 text-lg">
              Rp{{ number_format($order->total_price, 0, ',', '.') }}
            </p>
          </div>
        </div>

        {{-- Divider --}}
        <hr class="border-gray-200 dark:border-gray-800">

        {{-- Order Items --}}
        <div>
          <h4 class="font-semibold text-gray-800 dark:text-gray-100 mb-3">Order Items</h4>
          <div class="overflow-hidden rounded-xl border border-gray-200 dark:border-gray-800">
            <table class="min-w-full text-left text-sm">
              <thead class="bg-gray-50 dark:bg-gray-800/30 border-b border-gray-100 dark:border-gray-800">
                <tr>
                  <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Product</th>
                  <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300 text-center">Qty</th>
                  <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300 text-center">Price</th>
                  <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300 text-center">Subtotal</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @foreach ($order->items as $item)
                  <tr>
                    <td class="px-5 py-3 text-gray-800 dark:text-gray-100">
                      {{ $item->product->name ?? '-' }}
                    </td>
                    <td class="px-5 py-3 text-center text-gray-700 dark:text-gray-300">
                      {{ $item->qty }}
                    </td>
                    <td class="px-5 py-3 text-center text-gray-700 dark:text-gray-300">
                      Rp{{ number_format($item->price, 0, ',', '.') }}
                    </td>
                    <td class="px-5 py-3 text-center text-gray-700 dark:text-gray-300">
                      Rp{{ number_format($item->price * $item->qty, 0, ',', '.') }}
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot class="bg-gray-50 dark:bg-gray-800/20">
                <tr>
                  <td colspan="3" class="px-5 py-3 text-right font-medium text-gray-700 dark:text-gray-300">Subtotal:</td>
                  <td class="px-5 py-3 text-center font-semibold text-gray-900 dark:text-gray-100">
                    Rp{{ number_format($order->items->sum(fn($i) => $i->price * $i->qty), 0, ',', '.') }}
                  </td>
                </tr>
                <tr>
                  <td colspan="3" class="px-5 py-3 text-right font-medium text-gray-700 dark:text-gray-300">Shipping:</td>
                  <td class="px-5 py-3 text-center text-gray-700 dark:text-gray-300">
                    Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}
                  </td>
                </tr>
                <tr>
                  <td colspan="3" class="px-5 py-3 text-right font-bold text-gray-800 dark:text-gray-100">Total:</td>
                  <td class="px-5 py-3 text-center font-bold text-lg text-blue-600 dark:text-blue-400">
                    Rp{{ number_format($order->total_price, 0, ',', '.') }}
                  </td>
                </tr>
              </tfoot>
            </table>
          </div>
        </div>

        {{-- Actions --}}
        <div class="flex justify-end mt-6 gap-3">
          <a href="{{ route('orders.edit', $order) }}" 
             class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm">
            Edit
          </a>
          <button
            @click.prevent="
              title = '{{ $order->code }}'; 
              deleteUrl = '{{ route('orders.destroy', $order) }}'; 
              isModalOpen = true
            "
              class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm">
            Delete
          </button>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Delete Modal -->
  <x-modal.modal-delete />
</div>

@endsection