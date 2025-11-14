<?php $__env->startSection('title', 'Create Customer'); ?>

<?php $__env->startSection('content'); ?>
<nav class="mb-6 text-sm text-gray-500">
  <ol class="flex items-center space-x-2">
    <li><a href="<?php echo e(route('dashboard.index')); ?>" class="hover:underline">Dashboard</a></li>
    <li>/</li>
    <li><a href="<?php echo e(route('customers.index')); ?>" class="hover:underline">Customers</a></li>
    <li>/</li>
    <li class="text-gray-700 dark:text-gray-300">Create</li>
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
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Create Customer</h3>
        <a href="<?php echo e(route('customers.index')); ?>" class="text-sm text-blue-600 hover:underline">← Back</a>
      </div>

      <form action="<?php echo e(route('customers.store')); ?>" method="POST" enctype="multipart/form-data" class="border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800 space-y-6">
        <?php echo csrf_field(); ?>

        
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1">Username</label>
            <input type="text" name="username" value="<?php echo e(old('username')); ?>" class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white" placeholder="Enter username" required>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="<?php echo e(old('email')); ?>" class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white" placeholder="Enter email" required>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password" class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white" placeholder="Enter password" required>
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Phone</label>
            <input type="text" name="phone" value="<?php echo e(old('phone')); ?>" class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white" placeholder="e.g. 08123456789">
          </div>
        </div>

        
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
          <div class="px-5 py-4 sm:px-6 sm:py-5">
            <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Profile Image</h3>
          </div>
          <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
            <div id="dropzone" class="dropzone rounded-xl border border-dashed border-gray-300 bg-gray-50 p-7 lg:p-10 dark:border-gray-700 dark:bg-gray-900 cursor-pointer text-center">
              <input type="file" name="profile_image" id="fileInput" class="hidden" accept="image/*">
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
          <input type="text" name="name" value="<?php echo e(old('name')); ?>" class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white" placeholder="Enter customer name" required>
        </div>

        
        <div x-data="addressManager()" class="space-y-6">
          <template x-for="(address, index) in addresses" :key="index">
            <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-5 space-y-4">

              
              <div>
                <label class="block text-sm font-medium mb-1">Full Address</label>
                <textarea x-model="address.full_address" 
                  :name="`addresses[${index}][full_address]`"
                  rows="3"
                  placeholder="Enter full address" 
                  class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white" 
                  required></textarea>
              </div>

              
              <div class="grid md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium mb-1">Additional Information</label>
                  <input x-model="address.additional_information" 
                    :name="`addresses[${index}][additional_information]`" 
                    placeholder="Apartment, building, notes..." 
                    class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                </div>

                <div>
                  <label class="block text-sm font-medium mb-1">Label</label>
                  <select x-model="address.label" :name="`addresses[${index}][label]`" 
                          class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
                    <option value="Home">Home</option>
                    <option value="Work">Work</option>
                    <option value="Office">Office</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
              </div>

              
              <div>
                <label class="block text-sm font-medium mb-1">Postal Code</label>
                <input x-model="address.postal_code" 
                  :name="`addresses[${index}][postal_code]`"
                  placeholder="e.g. 80361"
                  class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white"
                  required>
              </div>

              
              <div>
                <div class="flex justify-between items-center mb-2">
                  <label class="block text-sm font-medium">Select Location</label>
                  <button type="button"
                    @click="findMyLocation(index)"
                    class="px-3 py-2 flex items-center gap-2 bg-green-600 text-white text-xs rounded-lg hover:bg-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pinned-icon lucide-map-pinned"><path d="M18 8c0 3.613-3.869 7.429-5.393 8.795a1 1 0 0 1-1.214 0C9.87 15.429 6 11.613 6 8a6 6 0 0 1 12 0"/><circle cx="12" cy="8" r="2"/><path d="M8.714 14h-3.71a1 1 0 0 0-.948.683l-2.004 6A1 1 0 0 0 3 22h18a1 1 0 0 0 .948-1.316l-2-6a1 1 0 0 0-.949-.684h-3.712"/></svg>
                    Find My Location
                  </button>
                </div>
                <div 
                  class="w-full h-96 rounded-lg border border-gray-300 dark:border-gray-700 overflow-hidden"
                  :id="`map-${index}`"
                  x-init="$nextTick(() => initMap(index))"
                ></div>
              </div>

              
              <div class="grid md:grid-cols-2 gap-4">
                <div>
                  <label class="block text-sm font-medium mb-1">Latitude</label>
                  <input type="text" x-model="address.latitude" 
                    :name="`addresses[${index}][latitude]`" 
                    class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600 cursor-not-allowed dark:bg-gray-800 dark:text-gray-400"
                    readonly>
                </div>
                <div>
                  <label class="block text-sm font-medium mb-1">Longitude</label>
                  <input type="text" x-model="address.longitude" 
                    :name="`addresses[${index}][longitude]`"
                    class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600 cursor-not-allowed dark:bg-gray-800 dark:text-gray-400"
                    readonly>
                </div>
              </div>

              
              <div class="flex items-center justify-between">
                <label class="flex cursor-pointer items-center gap-3 text-sm font-medium text-gray-700 dark:text-gray-300 select-none">
                  <div class="relative">
                    <input type="hidden" :name="`addresses[${index}][is_default]`" :value="address.is_default ? 1 : 0">
                    <input type="checkbox" class="sr-only" x-model="address.is_default"
                      @change="setDefaultAddress(index)">
                    <div class="block h-6 w-11 rounded-full transition-colors"
                        :class="address.is_default ? 'bg-blue-600 dark:bg-blue-500' : 'bg-gray-200 dark:bg-gray-700'"></div>
                    <div :class="address.is_default ? 'translate-x-full' : 'translate-x-0'"
                        class="absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white shadow transform transition duration-200 ease-in-out"></div>
                  </div>
                  <span>Default Address</span>
                </label>
              </div>

              <button type="button" @click="removeAddress(index)" 
                x-show="addresses.length > 1" 
                class="text-red-600 text-sm mt-2 hover:underline">Remove Address</button>
            </div>
          </template>

          <button type="button" 
            @click="addAddress()" 
            class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            + Add Address
          </button>
        </div>

        
        <div class="pt-4">
          <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition">Save Customer</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<style>
.leaflet-search-container {
  position: absolute;
  top: 10px;
  left: 50px;
  z-index: 1000;
  width: calc(100% - 60px);
  max-width: 400px;
  background: none;
}

.leaflet-search-input {
  width: 100%;
  padding: 8px 12px;
  border: 2px solid #e5e7eb;
  border-radius: 8px;
  font-size: 14px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  background-color: #fff;
}

.leaflet-search-input:focus {
  outline: none;
  border-color: #3b82f6;
}

.leaflet-search-results {
  list-style: none;
  padding: 0;
  margin: 4px 0 0 0;
  background: white;
  border-radius: 8px;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  max-height: 300px;
  overflow-y: auto;
}

.leaflet-search-results li {
  padding: 10px 12px;
  cursor: pointer;
  border-bottom: 1px solid #f3f4f6;
  font-size: 13px;
  color: #374151;
}

.leaflet-search-results li:hover {
  background-color: #f3f4f6;
}

.leaflet-search-results li:last-child {
  border-bottom: none;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('js'); ?>
<script>
// File upload preview
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
  // Parse addresses from PHP safely
  const initialAddresses = <?php echo Js::from($addresses ?? []); ?>;
  
  return {
    addresses: initialAddresses.length > 0 ? initialAddresses : [{
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
      console.log('Address Manager Initialized with', this.addresses.length, 'addresses');
    },

    initMap(index) {
      const mapEl = document.getElementById(`map-${index}`);
      
      // Prevent re-initialization
      if (!mapEl || this.maps[index]) {
        console.log(`Map ${index} already exists or element not found`);
        return;
      }

      console.log(`Initializing map ${index}`);

      // Default coordinates (Denpasar, Bali)
      const defaultLat = parseFloat(this.addresses[index].latitude) || -8.65;
      const defaultLng = parseFloat(this.addresses[index].longitude) || 115.2167;

      // Create map instance
      const map = L.map(mapEl).setView([defaultLat, defaultLng], 12);
      
      // Add tile layer
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap contributors'
      }).addTo(map);

      // Add draggable marker
      const marker = L.marker([defaultLat, defaultLng], { 
        draggable: true 
      }).addTo(map);

      // Store references
      this.maps[index] = map;
      this.markers[index] = marker;

      // Reverse geocode helper
      const updateLocation = async (lat, lng) => {
        this.addresses[index].latitude = lat.toFixed(8);
        this.addresses[index].longitude = lng.toFixed(8);
        
        try {
          const res = await fetch(
            `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1&accept-language=id`
          );
          const data = await res.json();
          
          if (data.display_name) {
            this.addresses[index].full_address = data.display_name;
          }
          if (data.address?.postcode) {
            this.addresses[index].postal_code = data.address.postcode;
          }
        } catch (err) {
          console.error('Reverse geocode error:', err);
        }
      };

      // Map click event
      map.on('click', (e) => {
        marker.setLatLng(e.latlng);
        updateLocation(e.latlng.lat, e.latlng.lng);
      });

      // Marker drag event
      marker.on('dragend', (e) => {
        const { lat, lng } = e.target.getLatLng();
        updateLocation(lat, lng);
      });

      // Add search box
      this.addSearchBox(mapEl, map, marker, index, updateLocation);

      // Fix map display after a short delay
      setTimeout(() => {
        map.invalidateSize();
      }, 100);
    },

    addSearchBox(mapEl, map, marker, index, updateLocation) {
      const searchContainer = document.createElement('div');
      searchContainer.className = 'leaflet-search-container';
      searchContainer.innerHTML = `
        <input type="text" class="leaflet-search-input" placeholder="Search location...">
        <ul class="leaflet-search-results"></ul>
      `;
      mapEl.appendChild(searchContainer);
      mapEl.style.position = 'relative';

      const searchInput = searchContainer.querySelector('.leaflet-search-input');
      const resultList = searchContainer.querySelector('.leaflet-search-results');
      let searchTimeout;

      searchInput.addEventListener('input', () => {
        clearTimeout(searchTimeout);
        const query = searchInput.value.trim();
        
        if (!query) {
          resultList.innerHTML = '';
          return;
        }

        searchTimeout = setTimeout(async () => {
          try {
            const res = await fetch(
              `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&addressdetails=1&limit=5`
            );
            const data = await res.json();
            
            resultList.innerHTML = data.map(r =>
              `<li data-lat="${r.lat}" data-lon="${r.lon}" data-display="${r.display_name}">${r.display_name}</li>`
            ).join('');
          } catch (err) {
            resultList.innerHTML = '<li>Search failed</li>';
          }
        }, 400);
      });

      resultList.addEventListener('click', (e) => {
        if (e.target.tagName !== 'LI') return;
        
        const { lat, lon, display } = e.target.dataset;
        const latNum = parseFloat(lat);
        const lonNum = parseFloat(lon);
        
        map.setView([latNum, lonNum], 16);
        marker.setLatLng([latNum, lonNum]);
        
        this.addresses[index].latitude = latNum.toFixed(8);
        this.addresses[index].longitude = lonNum.toFixed(8);
        this.addresses[index].full_address = display;
        
        resultList.innerHTML = '';
        searchInput.value = display;
      });
    },

    findMyLocation(index) {
      if (!navigator.geolocation) {
        alert('Geolocation is not supported by your browser');
        return;
      }

      navigator.geolocation.getCurrentPosition(
        (position) => {
          const { latitude, longitude } = position.coords;
          const map = this.maps[index];
          const marker = this.markers[index];

          if (map && marker) {
            map.setView([latitude, longitude], 16);
            marker.setLatLng([latitude, longitude]);
            
            this.addresses[index].latitude = latitude.toFixed(8);
            this.addresses[index].longitude = longitude.toFixed(8);

            // Reverse geocode
            fetch(
              `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}&zoom=18&addressdetails=1&accept-language=id`
            )
            .then(res => res.json())
            .then(data => {
              if (data.display_name) {
                this.addresses[index].full_address = data.display_name;
              }
              if (data.address?.postcode) {
                this.addresses[index].postal_code = data.address.postcode;
              }
            })
            .catch(err => console.error('Reverse geocode error:', err));
          }
        },
        (error) => {
          alert('Unable to retrieve your location');
          console.error('Geolocation error:', error);
        }
      );
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

      // Initialize map for new address after DOM update
      this.$nextTick(() => {
        setTimeout(() => {
          this.initMap(newIndex);
        }, 100);
      });
    },

    removeAddress(index) {
      // Remove map instance
      if (this.maps[index]) {
        this.maps[index].remove();
        delete this.maps[index];
        delete this.markers[index];
      }

      // Remove address
      this.addresses.splice(index, 1);

      // Ensure at least one address is default
      if (!this.addresses.some(a => a.is_default) && this.addresses.length > 0) {
        this.addresses[0].is_default = true;
      }
    },

    setDefaultAddress(index) {
      // Set only one address as default
      this.addresses.forEach((addr, i) => {
        addr.is_default = (i === index);
      });
    }
  };
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/admin/customers/create.blade.php ENDPATH**/ ?>