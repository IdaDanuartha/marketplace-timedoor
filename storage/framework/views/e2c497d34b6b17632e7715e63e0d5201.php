<?php $__env->startSection('title', 'Edit Customer'); ?>

<?php $__env->startSection('content'); ?>
<nav class="mb-6 text-sm text-gray-500">
  <ol class="flex items-center space-x-2">
    <li><a href="<?php echo e(route('dashboard.index')); ?>" class="hover:underline">Dashboard</a></li>
    <li>/</li>
    <li><a href="<?php echo e(route('customers.index')); ?>" class="hover:underline">Customers</a></li>
    <li>/</li>
    <li class="text-gray-700 dark:text-gray-300">Edit</li>
  </ol>
</nav>

<div class="grid grid-cols-12 gap-4 md:gap-6">
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
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Edit Customer</h3>
        <a href="<?php echo e(route('customers.index')); ?>" class="text-sm text-blue-600 hover:underline">← Back</a>
      </div>

      <form action="<?php echo e(route('customers.update', $customer)); ?>" method="POST" enctype="multipart/form-data" class="border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800 space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1">Username</label>
            <input type="text" name="username" value="<?php echo e(old('username', $customer->user->username)); ?>" class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white" required>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="<?php echo e(old('email', $customer->user->email)); ?>" class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white" required>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Password (Leave blank to keep current)</label>
            <input type="password" name="password" class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white" placeholder="••••••••">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Phone</label>
            <input type="text" name="phone" value="<?php echo e(old('phone', $customer->phone)); ?>" class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
          </div>
        </div>

        
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
          <div class="px-5 py-4 sm:px-6 sm:py-5 flex items-center justify-between">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Profile Image</h3>
            <?php if($customer->user->profile_image): ?>
              <img src="<?php echo e(profile_image($customer->user->profile_image)); ?>" class="w-16 h-16 rounded-full border object-cover" alt="Profile Image">
            <?php endif; ?>
          </div>
          <div class="border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
            <input type="file" name="profile_image" id="fileInput" accept="image/*" class="hidden">
            <div id="dropzone" class="dropzone rounded-xl border border-dashed border-gray-300 bg-gray-50 p-7 lg:p-10 dark:border-gray-700 dark:bg-gray-900 cursor-pointer text-center">
              <div id="preview" class="hidden mb-4 flex justify-center">
                <img id="previewImage" class="max-h-48 rounded-lg border">
              </div>
              <div id="dz-message" onclick="document.getElementById('fileInput').click()">
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90">Drop or Browse</h4>
                <p class="text-sm text-gray-500">Upload PNG, JPG, WEBP, or SVG image</p>
              </div>
            </div>
          </div>
        </div>

        
        <div>
          <label class="block text-sm font-medium mb-1">Customer Name</label>
          <input type="text" name="name" value="<?php echo e(old('name', $customer->name)); ?>" class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white" required>
        </div>

        
        <div x-data="addressManager()" class="space-y-6">
          <template x-for="(address, index) in addresses" :key="index">
            <?php echo $__env->make('admin.customers.partials.address-block', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
          </template>

          <button type="button" 
            @click="addAddress()" 
            class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            + Add Address
          </button>
        </div>

        
        <div class="pt-4">
          <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition">Update Customer</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>

<script>
document.getElementById('fileInput').addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('previewImage').src = e.target.result;
      document.getElementById('preview').classList.remove('hidden');
    };
    reader.readAsDataURL(file);
  }
});

function addressManager() {
  const initialAddresses = <?php echo Js::from(
    $customer->addresses->map(fn($a) => [
      'full_address' => $a->full_address,
      'additional_information' => $a->additional_information,
      'postal_code' => $a->postal_code,
      'latitude' => $a->latitude,
      'longitude' => $a->longitude,
      'label' => $a->label,
      'is_default' => (bool) $a->is_default,
    ])
  ); ?>;

  return {
    addresses: initialAddresses.length ? initialAddresses : [{
      full_address: '',
      additional_information: '',
      postal_code: '',
      latitude: '',
      longitude: '',
      label: 'Home',
      is_default: true
    }],
    maps: {},
    markers: {},

    init() {
      this.addresses.forEach((_, i) => setTimeout(() => this.initMap(i), 200));
    },

    initMap(index) {
      const mapEl = document.getElementById(`map-${index}`);
      if (!mapEl || this.maps[index]) return;

      const lat = parseFloat(this.addresses[index].latitude) || -8.65;
      const lng = parseFloat(this.addresses[index].longitude) || 115.2167;

      const map = L.map(mapEl).setView([lat, lng], 13);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18
      }).addTo(map);

      const marker = L.marker([lat, lng], { draggable: true }).addTo(map);
      this.maps[index] = map;
      this.markers[index] = marker;

      const updateLocation = async (lat, lng) => {
        this.addresses[index].latitude = lat.toFixed(8);
        this.addresses[index].longitude = lng.toFixed(8);
        try {
          const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1&accept-language=id`);
          const data = await res.json();
          if (data.display_name) this.addresses[index].full_address = data.display_name;
          if (data.address?.postcode) this.addresses[index].postal_code = data.address.postcode;
        } catch (err) {
          console.error(err);
        }
      };

      map.on('click', (e) => {
        marker.setLatLng(e.latlng);
        updateLocation(e.latlng.lat, e.latlng.lng);
      });

      marker.on('dragend', (e) => {
        const { lat, lng } = e.target.getLatLng();
        updateLocation(lat, lng);
      });
    },

    addAddress() {
      const newIndex = this.addresses.length;
      this.addresses.push({
        full_address: '',
        additional_information: '',
        postal_code: '',
        latitude: '',
        longitude: '',
        label: 'Home',
        is_default: false
      });
      this.$nextTick(() => setTimeout(() => this.initMap(newIndex), 150));
    },

    removeAddress(i) {
      this.addresses.splice(i, 1);
      if (!this.addresses.some(a => a.is_default) && this.addresses.length > 0)
        this.addresses[0].is_default = true;
    },

    setDefaultAddress(i) {
      this.addresses.forEach((a, idx) => a.is_default = idx === i);
    }
  };
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/admin/customers/edit.blade.php ENDPATH**/ ?>