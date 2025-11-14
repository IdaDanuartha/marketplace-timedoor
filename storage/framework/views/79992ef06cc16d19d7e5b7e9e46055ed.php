<?php $__env->startSection('title', 'Edit Order'); ?>

<?php $__env->startSection('content'); ?>
<nav class="mb-6 text-sm text-gray-500">
  <ol class="flex items-center space-x-2">
    <li><a href="<?php echo e(route('dashboard.index')); ?>" class="hover:underline">Dashboard</a></li>
    <li>/</li>
    <li><a href="<?php echo e(route('orders.index')); ?>" class="hover:underline">Orders</a></li>
    <li>/</li>
    <li class="text-gray-700 dark:text-gray-300">Edit</li>
  </ol>
</nav>

<div class="max-w-6xl mx-auto space-y-6"
     x-data="orderForm(<?php echo e($order->toJson()); ?>, <?php echo e($order->items->toJson()); ?>)"
     x-init="init()">

  
  <?php if($errors->any()): ?>
    <div class="rounded-lg border border-red-300 bg-red-50 p-4 text-red-700">
      <ul class="list-disc pl-5 space-y-1">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  <?php endif; ?>

  
  <div class="rounded-2xl border border-gray-200 bg-white dark:bg-gray-900/50">

    <div class="px-6 py-4 flex justify-between items-center border-b dark:border-gray-800">
      <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-100">
        Edit Order #<?php echo e($order->code); ?>

      </h3>
      <a href="<?php echo e(route('orders.index')); ?>" class="text-sm text-blue-600 hover:underline">← Back</a>
    </div>

    <form action="<?php echo e(route('orders.update', $order->id)); ?>" method="POST" class="p-6 space-y-6">
      <?php echo csrf_field(); ?>
      <?php echo method_field('PUT'); ?>

      
      <div class="grid sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium mb-1">Customer</label>
          <select name="customer_id" class="select2-customer w-full" required>
            <option value="">Select Customer</option>
            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($c->id); ?>" <?php echo e($order->customer_id == $c->id ? 'selected' : ''); ?>>
                <?php echo e($c->name); ?>

              </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Shipping Address</label>
          <select name="address_id" class="select2-address w-full" required>
            <option value="">Select Address</option>
            <?php $__currentLoopData = $addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option 
                value="<?php echo e($a->id); ?>" 
                data-district="<?php echo e($a->district_id); ?>"
                <?php echo e($order->address_id == $a->id ? 'selected' : ''); ?>

              >
                <?php echo e($a->label ? $a->label.' — '.$a->full_address : $a->full_address); ?>

              </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
      </div>

      
      <div class="grid sm:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm mb-1">Order Status</label>
          <select name="status" class="select2-status w-full">
            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($status->value); ?>"
                <?php echo e($order->status->value === $status->value ? 'selected' : ''); ?>>
                <?php echo e($status->label()); ?>

              </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

        <div>
          <label class="block text-sm mb-1">Payment Method</label>
          <select name="payment_method" class="select2-method w-full">
            <option value="">Select Method</option>
            <?php $__currentLoopData = ['bank_transfer','gopay','qris','midtrans']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($method); ?>" <?php echo e($order->payment_method === $method ? 'selected' : ''); ?>>
                <?php echo e(ucwords(str_replace('_',' ', $method))); ?>

              </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

        <div>
          <label class="block text-sm mb-1">Payment Status</label>
          <select name="payment_status" class="select2-payment w-full">
            <?php $__currentLoopData = ['unpaid','paid','failed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ps): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($ps); ?>" <?php echo e($order->payment_status === $ps ? 'selected' : ''); ?>>
                <?php echo e(ucfirst($ps)); ?>

              </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
      </div>

      
      <div>
        <label class="block text-sm font-medium mb-2">Order Items</label>

        <div class="overflow-x-auto border rounded-lg">
          <table class="min-w-full text-sm">
            <thead class="bg-gray-100 dark:bg-gray-800/40">
              <tr>
                <th class="px-4 py-2">Product</th>
                <th class="px-4 py-2 text-center">Qty</th>
                <th class="px-4 py-2 text-center">Price</th>
                <th class="px-4 py-2 text-center">Subtotal</th>
                <th class="px-4 py-2"></th>
              </tr>
            </thead>

            <tbody>
              <template x-for="(item,index) in items" :key="index">
                <tr class="border-t">
                  <td class="px-3 py-2">
                    <select :id="'product_'+index" x-model="item.product_id" class="select2-product w-full">
                      <option value="">Select Product</option>
                      <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option
                          value="<?php echo e($p->id); ?>"
                          data-price="<?php echo e($p->price); ?>"
                          data-weight="<?php echo e($p->weight ?? 0); ?>"
                        >
                          <?php echo e($p->name); ?>

                        </option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </td>

                  <td class="px-3 py-2 text-center">
                    <input type="number" min="1" x-model.number="item.qty"
                      @input="calculateWeight(); calculate();"
                      class="w-16 border rounded-lg text-center">
                  </td>

                  <td class="px-3 py-2 text-center">
                    <span x-text="formatPrice(item.price)"></span>
                  </td>

                  <td class="px-3 py-2 text-center">
                    <span x-text="formatPrice(item.price * item.qty)"></span>
                  </td>

                  <td class="px-3 py-2 text-center">
                    <button type="button" @click="removeItem(index)" class="text-red-600 hover:underline">
                      Remove
                    </button>
                  </td>
                </tr>
              </template>
            </tbody>

          </table>
        </div>

        <button type="button" @click="addItem"
          class="mt-3 px-4 py-2 bg-blue-600 text-white text-sm rounded-lg">
          + Add Item
        </button>
      </div>

      
      <div class="text-right space-y-2 pt-4">
        <div class="flex justify-between text-base">
          <span>Subtotal (Items):</span>
          <span x-text="formatPrice(total_price)" class="font-medium"></span>
        </div>

        <div class="flex justify-between text-base text-gray-500 items-center">
          <span>Shipping Cost:</span>

          <input 
            type="text"
            x-model="displayShipping"
            @input="formatShippingCost()"
            class="border rounded-lg px-3 py-1 w-40 text-right"
          />
        </div>

        <div class="border-t pt-2 mt-2"></div>

        <div class="flex justify-between text-lg font-semibold">
          <span>Grand Total:</span>
          <span x-text="formatPrice(grand_total)"></span>
        </div>
      </div>

      
      <template x-for="(item,i) in items" :key="'h'+i">
        <div>
          <input type="hidden" :name="'items['+i+'][product_id]'" :value="item.product_id">
          <input type="hidden" :name="'items['+i+'][qty]'" :value="item.qty">
          <input type="hidden" :name="'items['+i+'][price]'" :value="item.price">
        </div>
      </template>

      <input type="hidden" name="shipping_cost" :value="shipping_cost">
      <input type="hidden" name="total_price" :value="total_price">
      <input type="hidden" name="grand_total" :value="grand_total">

      <div class="pt-4">
        <button class="px-5 py-2.5 bg-blue-600 text-white rounded-lg text-sm">
          Update Order
        </button>
      </div>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<script>
let orderFormInstance = null;

function orderForm(order = {}, orderItems = []) {
  return {

    order: order,
    displayShipping: "",

    items: orderItems.map(it => ({
      product_id: it.product_id,
      qty: Number(it.qty),
      price: Number(it.price),
      weight: Number(it.weight ?? 0) * 1000
    })),

    shipping_cost: Number(order.shipping_cost ?? 0),
    total_price: Number(order.total_price ?? 0),
    grand_total: Number(order.grand_total ?? 0),

    totalWeight: 0,
    selectedAddressDistrict: null,

    init() {
      orderFormInstance = this;

      $('.select2-customer, .select2-address, .select2-status, .select2-payment, .select2-method')
        .select2({ width: '100%' });

      this.reinitProductSelect();
      this.calculateWeight();
      this.calculate();
      this.displayShipping = this.formatPrice(this.shipping_cost);
    },

    formatShippingCost() {
      const number = Number(this.displayShipping.replace(/[^0-9]/g, ""));

      this.shipping_cost = isNaN(number) ? 0 : number;
      this.displayShipping = this.formatPrice(this.shipping_cost);

      this.calculate();
    },

    // ITEMS
    addItem() {
      this.items.push({
        product_id: "",
        qty: 1,
        price: 0,
        weight: 0
      });
      this.$nextTick(() => this.reinitProductSelect());
    },

    removeItem(i) {
      this.items.splice(i, 1);
      this.calculateWeight();
      this.calculate();
    },

    updatePrice(index) {
      const el = document.getElementById("product_" + index);
      if (!el) return;

      const selected = el.options[el.selectedIndex];
      this.items[index].price = Number(selected?.dataset?.price ?? 0);
      this.items[index].weight = Number(selected?.dataset?.weight ?? 0) * 1000;

      this.calculateWeight();
      this.calculate();
    },

    // CALCULATIONS
    calculateWeight() {
      this.totalWeight = this.items.reduce((sum, item) => sum + (item.qty * item.weight), 0);
    },

    calculate() {
      const itemsTotal = this.items.reduce((sum, it) => sum + (it.qty * it.price), 0);

      this.total_price = itemsTotal;
      this.grand_total = itemsTotal + this.shipping_cost;
    },

    formatPrice(v) {
      const n = Number(v) || 0;
      return 'Rp' + n.toLocaleString('id-ID');
    },

    // SELECT2
    reinitProductSelect() {
      this.$nextTick(() => {
        $('.select2-product').each((i, el) => {
          if (!$(el).data('select2')) {
            $(el).select2({ width: '100%' }).on('change', e => {
              const index = e.target.id.split('_')[1];
              this.items[index].product_id = e.target.value;
              this.updatePrice(index);
            });
          }
        });

        this.items.forEach((item, i) => {
          const el = document.getElementById("product_" + i);
          if (el && item.product_id) {
            $(el).val(item.product_id).trigger("change");
          }
        });
      });
    },
  };
}

// ADDRESS CHANGE EVENT
document.addEventListener('DOMContentLoaded', function() {
  $('.select2-address').on('change', function () {
    const district = this.options[this.selectedIndex]?.dataset?.district;

    if (orderFormInstance) {
      orderFormInstance.selectedAddressDistrict = district ? Number(district) : null;
    }
  });

  $('.select2-customer').on('change', function () {
    const customerId = $(this).val();
    const $addressSelect = $('.select2-address');

    $addressSelect.empty().append('<option value="">Select Address</option>').trigger('change');

    if (!customerId) return;

    fetch(`/api/orders/get-addresses/${customerId}`)
      .then(res => res.json())
      .then(data => {
        $addressSelect.empty().append('<option value="">Select Address</option>');

        if (data.length === 0) {
          $addressSelect.append('<option disabled>No address found</option>');
        } else {
          data.forEach(addr => {
            const option = new Option(
              addr.label ? `${addr.label} — ${addr.full_address}` : addr.full_address,
              addr.id
            );
            option.dataset.district = addr.district_id;
            $addressSelect.append(option);
          });
        }

        $addressSelect.trigger('change');
      });
  });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/admin/orders/edit.blade.php ENDPATH**/ ?>