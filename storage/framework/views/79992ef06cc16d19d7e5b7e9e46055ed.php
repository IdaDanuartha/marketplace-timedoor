<?php $__env->startSection('title', 'Edit Order'); ?>

<?php $__env->startSection('content'); ?>
<!-- Breadcrumb -->
<nav class="mb-6 text-sm text-gray-500">
  <ol class="flex items-center space-x-2">
    <li><a href="<?php echo e(route('dashboard.index')); ?>" class="hover:underline">Dashboard</a></li>
    <li>/</li>
    <li>
      <a href="<?php echo e(route('orders.index')); ?>" class="hover:underline">Orders</a>
    </li>
    <li>/</li>
    <li class="text-gray-700 dark:text-gray-300">Edit Order</li>
  </ol>
</nav>

<div class="grid grid-cols-12 gap-4 md:gap-6" 
     x-data="orderForm(<?php echo e($order->toJson()); ?>, <?php echo e($order->items->toJson()); ?>)"
     x-init="init()">
  <div class="col-span-12">
      
      <?php if($errors->any()): ?>
        <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700 dark:border-red-700/40 dark:bg-red-900/30 dark:text-red-300">
          <ul class="list-disc pl-5 space-y-1">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>
      <?php endif; ?>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
      <div class="px-5 py-4 sm:px-6 sm:py-5 flex items-center justify-between">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Edit Order</h3>
        <a href="<?php echo e(route('orders.index')); ?>" class="text-sm text-blue-600 hover:underline">← Back</a>
      </div>

      <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
        <form action="<?php echo e(route('orders.update', $order)); ?>" method="POST">
          <?php echo csrf_field(); ?>
          <?php echo method_field('PUT'); ?>

          
          <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Customer</label>
            <select name="customer_id" class="select2-customer w-full" required>
              <option value="">Select Customer</option>
              <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($customer->id); ?>" <?php echo e($order->customer_id == $customer->id ? 'selected' : ''); ?>>
                  <?php echo e($customer->name); ?>

                </option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['customer_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          
          <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Order Status</label>
            <select name="status" class="select2-status w-full">
              <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($status->name); ?>" <?php echo e($order->status->name === $status->name ? 'selected' : ''); ?>>
                  <?php echo e($status->label()); ?>

                </option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          
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
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($product->id); ?>" data-price="<?php echo e($product->price); ?>">
                            <?php echo e($product->name); ?>

                          </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

            <?php $__errorArgs = ['items'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-sm text-red-500 mt-2"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <button type="button" @click="addItem" 
                    class="mt-3 px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
              + Add Item
            </button>
          </div>

          
          <div class="grid grid-cols-2 gap-4 mt-6">
            <div>
              <label class="block text-sm font-medium mb-1">Shipping Cost</label>
              <input type="number" x-model.number="shipping_cost" @input="calculate()" name="shipping_cost"
                     class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
              <?php $__errorArgs = ['shipping_cost'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="flex flex-col justify-end">
              <div class="flex justify-between font-medium text-gray-700 dark:text-gray-300">
                <span>Total Price:</span>
                <span x-text="formatPrice(total_price)"></span>
              </div>
            </div>
          </div>

          
          <template x-for="(item, i) in items" :key="'hidden'+i">
            <div>
              <input type="hidden" :name="'items['+i+'][product_id]'" :value="item.product_id">
              <input type="hidden" :name="'items['+i+'][qty]'" :value="item.qty">
              <input type="hidden" :name="'items['+i+'][price]'" :value="item.price">
            </div>
          </template>
          <input type="hidden" name="total_price" :value="total_price">
          <?php $__errorArgs = ['total_price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

          
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/admin/orders/edit.blade.php ENDPATH**/ ?>