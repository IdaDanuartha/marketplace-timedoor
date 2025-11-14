<?php $__env->startSection('title', 'Create Order'); ?>

<?php $__env->startSection('content'); ?>
<nav class="mb-6 text-sm text-gray-500">
  <ol class="flex items-center space-x-2">
    <li><a href="<?php echo e(route('dashboard.index')); ?>" class="hover:underline">Dashboard</a></li>
    <li>/</li>
    <li><a href="<?php echo e(route('orders.index')); ?>" class="hover:underline">Orders</a></li>
    <li>/</li>
    <li class="text-gray-700 dark:text-gray-300">Create</li>
  </ol>
</nav>

<div class="max-w-6xl mx-auto space-y-6" x-data="orderForm()" x-init="init()">

  
  <?php if($errors->any()): ?>
    <div class="rounded-lg border border-red-300 bg-red-50 p-4 text-red-700 dark:bg-red-900/20 dark:border-red-800 dark:text-red-300">
      <ul class="list-disc pl-5 space-y-1">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  <?php endif; ?>

  
  <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900/50">
    <div class="px-6 py-4 flex justify-between items-center border-b dark:border-gray-800">
      <h3 class="font-semibold text-lg text-gray-800 dark:text-gray-100">Create Order</h3>
      <a href="<?php echo e(route('orders.index')); ?>" class="text-sm text-blue-600 hover:underline">← Back</a>
    </div>

    <form action="<?php echo e(route('orders.store')); ?>" method="POST" class="p-6 space-y-6">
      <?php echo csrf_field(); ?>

      
      <div class="grid sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium mb-1">Customer</label>
          <select name="customer_id" class="select2-customer w-full" required>
            <option value="">Select Customer</option>
            <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($c->id); ?>"><?php echo e($c->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Shipping Address</label>
          <select name="address_id" id="address_id" class="select2-address w-full" required>
            <option value="">Select Address</option>
          </select>
        </div>
      </div>

      
      <div class="grid sm:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-medium mb-1">Order Status</label>
          <select name="status" class="select2-status w-full">
            <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($status->value); ?>" 
                <?php echo e($status->value === \App\Enum\OrderStatus::PENDING->value ? 'selected' : ''); ?>>
                <?php echo e($status->label()); ?>

              </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Payment Method</label>
          <select name="payment_method" class="select2-method w-full">
            <option value="">Select Method</option>
            <?php $__currentLoopData = ['bank_transfer', 'gopay', 'qris', 'midtrans']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($method); ?>"><?php echo e(ucwords(str_replace('_',' ', $method))); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Payment Status</label>
          <select name="payment_status" class="select2-payment w-full">
            <?php $__currentLoopData = ['unpaid', 'paid', 'failed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ps): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($ps); ?>" <?php echo e($ps === 'unpaid' ? 'selected' : ''); ?>><?php echo e(ucfirst($ps)); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>
      </div>

      
      <div>
        <label class="block text-sm font-medium mb-2">Order Items</label>
        <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg">
          <table class="min-w-full text-sm">
            <thead class="bg-gray-100 dark:bg-gray-800/40">
              <tr>
                <th class="px-4 py-2 text-left">Product</th>
                <th class="px-4 py-2 text-center">Qty</th>
                <th class="px-4 py-2 text-center">Price</th>
                <th class="px-4 py-2 text-center">Subtotal</th>
                <th class="px-4 py-2 text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <template x-for="(item, index) in items" :key="index">
                <tr class="border-t dark:border-gray-700">
                  <td class="px-3 py-2">
                    <select :id="'product_'+index" x-model="item.product_id" class="select2-product w-full">
                      <option value="">Select Product</option>
                      <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($p->id); ?>" data-price="<?php echo e($p->price); ?>" data-weight="<?php echo e($p->weight ?? 0); ?>">
                          <?php echo e($p->name); ?>

                        </option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </td>
                  <td class="px-3 py-2 text-center">
                    <input type="number" min="1" x-model.number="item.qty" 
                      @input="calculateWeight(); calculate();" 
                      class="w-16 border rounded-lg text-center dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                  </td>
                  <td class="px-3 py-2 text-center">
                    <span x-text="formatPrice(item.price)"></span>
                  </td>
                  <td class="px-3 py-2 text-center">
                    <span x-text="formatPrice(item.price * item.qty)"></span>
                  </td>
                  <td class="px-3 py-2 text-center">
                    <button type="button" @click="removeItem(index)" class="text-red-600 hover:underline">Remove</button>
                  </td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>

        <button type="button" @click="addItem"
          class="mt-3 px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">
          + Add Item
        </button>
      </div>

      
      <div class="space-y-2">
        <label class="block text-sm font-medium">Shipping Courier</label>

        
        <select 
          x-model="selectedCourier" 
          @change="fetchCourierOptions"
          :disabled="!selectedAddressDistrict || totalWeight === 0"
          class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white disabled:bg-gray-100 disabled:cursor-not-allowed dark:disabled:bg-gray-800"
        >
          <option value="">
            <template x-if="!selectedAddressDistrict">Select address first</template>
            <template x-if="selectedAddressDistrict && totalWeight === 0">Add products first</template>
            <template x-if="selectedAddressDistrict && totalWeight > 0">Select Courier</template>
          </option>
          <option value="jne" :disabled="!selectedAddressDistrict || totalWeight === 0">JNE</option>
          <option value="jnt" :disabled="!selectedAddressDistrict || totalWeight === 0">J&T</option>
          <option value="sicepat" :disabled="!selectedAddressDistrict || totalWeight === 0">SiCepat</option>
          <option value="anteraja" :disabled="!selectedAddressDistrict || totalWeight === 0">AnterAja</option>
          <option value="tiki" :disabled="!selectedAddressDistrict || totalWeight === 0">TIKI</option>
          <option value="pos" :disabled="!selectedAddressDistrict || totalWeight === 0">POS</option>
        </select>

        
        <template x-if="!selectedAddressDistrict">
          <div class="text-sm text-amber-600 dark:text-amber-400 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
              <line x1="12" y1="9" x2="12" y2="13"/>
              <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
            <span>Please select shipping address first</span>
          </div>
        </template>

        <template x-if="selectedAddressDistrict && totalWeight === 0">
          <div class="text-sm text-amber-600 dark:text-amber-400 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
              <line x1="12" y1="9" x2="12" y2="13"/>
              <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
            <span>Please add products to calculate shipping weight</span>
          </div>
        </template>

        <template x-if="selectedAddressDistrict && totalWeight > 0">
          <div class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 7h-9"/>
              <path d="M14 17H5"/>
              <circle cx="17" cy="17" r="3"/>
              <circle cx="7" cy="7" r="3"/>
            </svg>
            <span>Total Weight: <strong x-text="totalWeight + ' gram'"></strong></span>
          </div>
        </template>

        
        <template x-if="loadingCourier">
          <div class="text-sm text-gray-500 dark:text-gray-400 animate-pulse flex items-center gap-2">
            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            Loading shipping options...
          </div>
        </template>

        
        <template x-if="courierServices.length > 0">
          <div class="space-y-2 mt-3">
            <label class="block text-sm font-medium">Service</label>

            <select 
              @change="selectService"
              class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white"
            >
              <option value="">Choose Service</option>
              <template x-for="srv in courierServices" :key="srv.code + srv.service">
                <option 
                  :value="srv.code + '|' + srv.service + '|' + srv.cost"
                  x-text="srv.name + ' — ' + srv.service + ' (' + formatPrice(srv.cost) + ')  •  ' + (srv.etd || '-')"
                ></option>
              </template>
            </select>
          </div>
        </template>

        
        <template x-if="!loadingCourier && selectedCourier && courierServices.length === 0">
          <div class="text-sm text-red-600 dark:text-red-400 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10"/>
              <line x1="15" y1="9" x2="9" y2="15"/>
              <line x1="9" y1="9" x2="15" y2="15"/>
            </svg>
            <span>No shipping services available for this route</span>
          </div>
        </template>
      </div>

      
      <div class="grid sm:grid-cols-1 gap-4 pt-4">
        <div class="flex flex-col justify-end text-gray-700 dark:text-gray-200 space-y-2 text-right">
          <div class="flex justify-between text-base">
            <span>Subtotal (Items):</span>
            <span x-text="formatPrice(total_price)" class="font-medium"></span>
          </div>
          
          <div class="flex justify-between text-base text-gray-500 dark:text-gray-400">
            <span>Shipping Cost:</span>
            <span x-text="formatPrice(shipping_cost)"></span>
          </div>
          
          <div class="border-t border-gray-200 dark:border-gray-700 pt-2 mt-2"></div>
          
          <div class="flex justify-between text-lg font-semibold">
            <span>Grand Total:</span>
            <span x-text="formatPrice(grand_total)" class="text-blue-600 dark:text-blue-400"></span>
          </div>
        </div>
      </div>

      
      <template x-for="(item, i) in items" :key="'h'+i">
        <div>
          <input type="hidden" :name="'items['+i+'][product_id]'" :value="item.product_id">
          <input type="hidden" :name="'items['+i+'][qty]'" :value="item.qty">
          <input type="hidden" :name="'items['+i+'][price]'" :value="item.price">
        </div>
      </template>
      <input type="hidden" name="total_price" :value="total_price">
      <input type="hidden" name="shipping_cost" :value="shipping_cost">
      <input type="hidden" name="grand_total" :value="grand_total">

      <div class="pt-4 flex gap-3">
        <button type="submit" 
          :disabled="items.length === 0 || !selectedAddressDistrict || totalWeight === 0"
          :class="(items.length === 0 || !selectedAddressDistrict || totalWeight === 0) ? 'opacity-50 cursor-not-allowed' : 'hover:bg-blue-700'"
          class="px-5 py-2.5 bg-blue-600 text-white text-sm rounded-lg transition">
          Save Order
        </button>
        <a href="<?php echo e(route('orders.index')); ?>" 
          class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm rounded-lg transition dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200">
          Cancel
        </a>
      </div>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<script>
// Global reference to Alpine component
let orderFormInstance = null;

function orderForm() {
  return {
    // Items
    items: [],
    
    // Costs & Weight
    shipping_cost: 0,
    total_price: 0,
    grand_total: 0,
    totalWeight: 0,
    
    // Courier
    selectedCourier: '',
    selectedAddressDistrict: null,
    courierServices: [],
    loadingCourier: false,

    // Fetch courier shipping options
    async fetchCourierOptions() {
      // Validate courier selection
      if (!this.selectedCourier) {
        this.courierServices = [];
        this.shipping_cost = 0;
        this.calculate();
        return;
      }

      // Validate address selection
      if (!this.selectedAddressDistrict) {
        alert('Please select a shipping address first');
        this.selectedCourier = '';
        this.courierServices = [];
        this.shipping_cost = 0;
        this.calculate();
        return;
      }

      // Validate weight
      if (this.totalWeight === 0) {
        alert('Please add products first to calculate shipping weight');
        this.selectedCourier = '';
        this.courierServices = [];
        this.shipping_cost = 0;
        this.calculate();
        return;
      }

      this.loadingCourier = true;
      this.courierServices = [];
      this.shipping_cost = 0;
      this.calculate();

      try {
        const payload = {
          courier: this.selectedCourier,
          destination: this.selectedAddressDistrict,
          weight: this.totalWeight // Use calculated total weight
        };

        console.log('Fetching shipping with:', payload);

        const res = await fetch('/api/shipping/calculate', {
          method: 'POST',
          headers: { 
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          },
          body: JSON.stringify(payload)
        });

        if (!res.ok) {
          throw new Error('Failed to fetch shipping options');
        }

        const json = await res.json();
        this.courierServices = json.data ?? [];

        if (this.courierServices.length === 0) {
          alert('No shipping services available for selected courier and destination');
        }
      } catch (error) {
        console.error('Courier fetch error:', error);
        alert('Failed to load shipping options. Please try again.');
        this.selectedCourier = '';
      } finally {
        this.loadingCourier = false;
      }
    },

    // Select shipping service
    selectService(e) {
      const value = e.target.value;
      if (!value) return;

      const [code, service, cost] = value.split('|');
      this.shipping_cost = Number(cost);
      this.calculate();
    },

    // Add new item
    addItem() {
      this.items.push({ 
        product_id: '', 
        qty: 1, 
        price: 0,
        weight: 0 
      });
      this.$nextTick(() => this.reinitProductSelect());
    },

    // Remove item
    removeItem(i) {
      this.items.splice(i, 1);
      this.calculateWeight();
      this.calculate();
      
      // Reset courier if weight becomes 0
      if (this.totalWeight === 0) {
        this.selectedCourier = '';
        this.courierServices = [];
        this.shipping_cost = 0;
      }
    },

    // Update price and weight when product selected
    updatePrice(i) {
      const el = document.getElementById('product_' + i);
      const selected = el.options[el.selectedIndex];
      this.items[i].price = Number(selected?.dataset?.price || 0);
      this.items[i].weight = Number(selected?.dataset?.weight || 0) * 1000;
      this.calculateWeight();
      this.calculate();
      
      // Reset courier when weight changes
      if (this.selectedCourier) {
        this.selectedCourier = '';
        this.courierServices = [];
        this.shipping_cost = 0;
        this.calculate();
      }
    },

    // Calculate total weight
    calculateWeight() {
      this.totalWeight = this.items.reduce((sum, item) => {
        return sum + ((item.qty || 0) * (item.weight || 0));
      }, 0);
      
      console.log('Total weight calculated:', this.totalWeight, 'gram');
    },

    // Calculate totals
    calculate() {
      const itemsTotal = this.items.reduce((sum, it) => {
        return sum + ((it.qty || 0) * (it.price || 0));
      }, 0);
      
      this.total_price = itemsTotal;
      this.grand_total = itemsTotal + (this.shipping_cost || 0);
    },

    // Format price to IDR
    formatPrice(v) {
      return 'Rp' + (v || 0).toLocaleString('id-ID');
    },

    // Reinitialize product select2
    reinitProductSelect() {
      this.$nextTick(() => {
        $('.select2-product').each((i, el) => {
          if (!$(el).data('select2')) {
            $(el).select2({ 
              width: '100%',
              placeholder: 'Select Product'
            }).on('change', e => {
              const idx = e.target.id.split('_')[1];
              this.items[idx].product_id = e.target.value;
              this.updatePrice(idx);
            });
          }
        });
      });
    },

    // Initialize
    init() {
      // Store global reference
      orderFormInstance = this;

      // Initialize select2
      $('.select2-customer, .select2-address, .select2-status, .select2-payment, .select2-method').select2({
        width: '100%'
      });

      this.reinitProductSelect();

      console.log('Order form initialized');
    }
  };
}

// Customer address loading
document.addEventListener('DOMContentLoaded', function () {
  // When customer changes, load their addresses
  $('.select2-customer').on('change', function () {
    const customerId = $(this).val();
    const $addressSelect = $('.select2-address');
    
    // Reset address and courier
    $addressSelect.empty().append('<option value="">Loading...</option>').trigger('change');
    if (orderFormInstance) {
      orderFormInstance.selectedAddressDistrict = null;
      orderFormInstance.selectedCourier = '';
      orderFormInstance.courierServices = [];
    }

    if (!customerId) {
      $addressSelect.html('<option value="">Select Address</option>').trigger('change');
      return;
    }

    // Fetch addresses for selected customer
    fetch(`/api/orders/get-addresses/${customerId}`)
      .then(res => {
        if (!res.ok) throw new Error('Failed to fetch addresses');
        return res.json();
      })
      .then(data => {
        $addressSelect.empty().append('<option value="">Select Address</option>');

        if (data.length === 0) {
          $addressSelect.append('<option disabled>No address found for this customer</option>');
        } else {
          data.forEach(addr => {
            const label = addr.label 
              ? `${addr.label} — ${addr.full_address}` 
              : addr.full_address;
            
            const option = new Option(label, addr.id);
            option.dataset.district = addr.district_id;
            
            $addressSelect.append(option);
          });
        }

        $addressSelect.trigger('change');
      })
      .catch(err => {
        console.error('Address fetch error:', err);
        $addressSelect.empty()
          .append('<option disabled>Error loading addresses</option>')
          .trigger('change');
      });
  });

  // When address changes, update district for courier calculation
  $('.select2-address').on('change', function () {
    const selectedOption = this.options[this.selectedIndex];
    const districtId = selectedOption?.dataset?.district;
    
    if (orderFormInstance) {
      // Parse as integer, fallback to null if invalid
      orderFormInstance.selectedAddressDistrict = districtId ? parseInt(districtId, 10) : null;
      
      // Reset courier selection when address changes
      orderFormInstance.selectedCourier = '';
      orderFormInstance.courierServices = [];
      
      // Debug log
      console.log('Address changed:', {
        addressId: $(this).val(),
        districtId: orderFormInstance.selectedAddressDistrict
      });
    }
  });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/admin/orders/create.blade.php ENDPATH**/ ?>