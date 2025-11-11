@extends('layouts.app')

@section('title', 'Edit Order')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6" 
     x-data="orderForm({{ $order->toJson() }}, {{ $order->items->toJson() }})"
     x-init="init()">
  <div class="col-span-12">
      {{-- Flash & Errors --}}
      @if ($errors->any())
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700 dark:border-red-700/40 dark:bg-red-900/30 dark:text-red-300">
          <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
      <div class="px-5 py-4 sm:px-6 sm:py-5 flex items-center justify-between">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Edit Order</h3>
        <a href="{{ route('orders.index') }}" class="text-sm text-blue-600 hover:underline">← Back</a>
      </div>

      <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
        <form action="{{ route('orders.update', $order) }}" method="POST">
          @csrf
          @method('PUT')

          {{-- Customer --}}
          <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Customer</label>
            <select name="customer_id" class="select2-customer w-full" required>
              <option value="">Select Customer</option>
              @foreach ($customers as $customer)
                <option value="{{ $customer->id }}" {{ $order->customer_id == $customer->id ? 'selected' : '' }}>
                  {{ $customer->name }}
                </option>
              @endforeach
            </select>
            @error('customer_id')
              <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- Status --}}
          <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Order Status</label>
            <select name="status" class="select2-status w-full">
              @foreach ($statuses as $status)
                <option value="{{ $status->name }}" {{ $order->status->name === $status->name ? 'selected' : '' }}>
                  {{ $status->label() }}
                </option>
              @endforeach
            </select>
            @error('status')
              <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- Order Items --}}
          <div class="mb-4">
            <label class="block text-sm font-medium mb-2">Order Items</label>

            <table class="min-w-full border border-gray-200 dark:border-gray-700 rounded-lg text-sm">
              <thead class="bg-gray-100 dark:bg-gray-800/30">
                <tr>
                  <th class="px-4 py-2 text-gray-700 dark:text-gray-300">Product</th>
                  <th class="px-4 py-2 text-gray-700 dark:text-gray-300 text-center">Qty</th>
                  <th class="px-4 py-2 text-gray-700 dark:text-gray-300 text-center">Price</th>
                  <th class="px-4 py-2 text-gray-700 dark:text-gray-300 text-center">Subtotal</th>
                  <th class="px-4 py-2 text-gray-700 dark:text-gray-300 text-center">Action</th>
                </tr>
              </thead>
              <tbody>
                <template x-for="(item, index) in items" :key="index">
                  <tr>
                    <td class="px-3 py-2">
                      <select x-model="item.product_id"
                              :id="'product_'+index"
                              class="select2-product w-full"
                              data-placeholder="Select Product">
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                          <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                            {{ $product->name }}
                          </option>
                        @endforeach
                      </select>
                    </td>
                    <td class="px-3 py-2 text-center">
                      <input type="number" x-model.number="item.qty" @input="calculate()" min="1" 
                             class="w-16 text-center border rounded-lg dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                    </td>
                    <td class="px-3 py-2 text-center">
                      <span x-text="formatPrice(item.price)"></span>
                    </td>
                    <td class="px-3 py-2 text-center">
                      <span x-text="formatPrice(item.price * item.qty)"></span>
                    </td>
                    <td class="px-3 py-2 text-center">
                      <button type="button" @click="removeItem(index)" 
                              class="text-red-600 hover:underline">Remove</button>
                    </td>
                  </tr>
                </template>
              </tbody>
            </table>

            @error('items')
              <p class="text-sm text-red-500 mt-2">{{ $message }}</p>
            @enderror

            <button type="button" @click="addItem" 
                    class="mt-3 px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
              + Add Item
            </button>
          </div>

          {{-- Shipping & Total --}}
          <div class="grid grid-cols-2 gap-4 mt-6">
            <div>
              <label class="block text-sm font-medium mb-1">Shipping Cost</label>
              <input type="number" x-model.number="shipping_cost" @input="calculate()" name="shipping_cost"
                     class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
              @error('shipping_cost')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
              @enderror
            </div>
            <div class="flex flex-col justify-end">
              <div class="flex justify-between font-medium text-gray-700 dark:text-gray-300">
                <span>Total Price:</span>
                <span x-text="formatPrice(total_price)"></span>
              </div>
            </div>
          </div>

          {{-- Hidden Inputs --}}
          <template x-for="(item, i) in items" :key="'hidden'+i">
            <div>
              <input type="hidden" :name="'items['+i+'][product_id]'" :value="item.product_id">
              <input type="hidden" :name="'items['+i+'][qty]'" :value="item.qty">
              <input type="hidden" :name="'items['+i+'][price]'" :value="item.price">
            </div>
          </template>
          <input type="hidden" name="total_price" :value="total_price">
          @error('total_price')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
          @enderror

          {{-- Submit --}}
          <div class="pt-4">
            <button type="submit"
              class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition">
              Update Order
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
  function orderForm(order = {}, orderItems = []) {
    return {
      items: orderItems.map(it => ({
        product_id: it.product_id,
        qty: it.qty,
        price: it.price
      })),
      shipping_cost: order.shipping_cost || 0,
      total_price: order.total_price || 0,

      addItem() {
        this.items.push({ product_id: '', qty: 1, price: 0 });
        this.$nextTick(() => this.reinitProductSelect());
      },

      removeItem(i) {
        this.items.splice(i, 1);
        this.calculate();
      },

      updatePrice(i) {
        const selectEl = document.getElementById('product_' + i);
        if (!selectEl) return;
        const selected = selectEl.options[selectEl.selectedIndex];
        this.items[i].price = Number(selected?.dataset?.price || 0);
        this.calculate();
      },

      calculate() {
        const itemsTotal = this.items.reduce((sum, it) => sum + (it.qty * it.price), 0);
        this.total_price = itemsTotal + (this.shipping_cost || 0);
      },

      formatPrice(v) {
        return 'Rp' + (v || 0).toLocaleString('id-ID');
      },

      reinitProductSelect() {
        this.$nextTick(() => {
          $('.select2-product').each((i, el) => {
            if (!$(el).data('select2')) {
              $(el).select2({
                width: '100%',
                placeholder: 'Select Product',
                minimumResultsForSearch: 0,
              }).on('change', (e) => {
                const index = e.target.id.split('_')[1];
                this.items[index].product_id = e.target.value;
                this.updatePrice(index);
              });
            }
          });

          // set selected values after init
          this.items.forEach((item, i) => {
            const el = document.getElementById('product_' + i);
            if (el && item.product_id) {
              $(el).val(item.product_id).trigger('change');
            }
          });
        });
      },

      init() {
        $('.select2-customer, .select2-status').select2({
          width: '100%',
          minimumResultsForSearch: 0
        });
        this.reinitProductSelect();
        this.calculate();
      }
    };
  }
</script>
@endpush