<?php $__env->startSection('title', 'Edit Address'); ?>

<?php $__env->startSection('content'); ?>
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

    
    <?php if(session('success')): ?>
      <div class="mb-4 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700 dark:border-green-700/40 dark:bg-green-900/30 dark:text-green-300">
        <?php echo e(session('success')); ?>

      </div>
    <?php endif; ?>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
      <div class="px-5 py-4 sm:px-6 sm:py-5 flex items-center justify-between">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Edit Address</h3>
        <a href="<?php echo e(route('profile.addresses.index')); ?>" class="text-sm text-blue-600 hover:underline dark:text-blue-400">← Back</a>
      </div>

      <form action="<?php echo e(route('profile.addresses.update', $address)); ?>" method="POST" class="border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800 space-y-6">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        
        <div>
          <label class="block text-sm font-medium mb-1">Label</label>
          <select name="label" class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
            <option <?php if(old('label', $address->label) == 'Home'): echo 'selected'; endif; ?> value="Home">Home</option>
            <option <?php if(old('label', $address->label) == 'Work'): echo 'selected'; endif; ?> value="Work">Work</option>
            <option <?php if(old('label', $address->label) == 'Office'): echo 'selected'; endif; ?> value="Office">Office</option>
            <option <?php if(old('label', $address->label) == 'Other'): echo 'selected'; endif; ?> value="Other">Other</option>
          </select>
        </div>

        
        <div>
          <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Full Address</label>
          <textarea name="full_address" id="full_address" rows="3"
            class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            placeholder="Click on the map or use search to update address"
            required><?php echo e(old('full_address', $address->full_address)); ?></textarea>
        </div>

        
        <div>
          <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Additional Information</label>
          <input type="text" name="additional_information" 
            value="<?php echo e(old('additional_information', $address->additional_information)); ?>"
            placeholder="Apartment number, building name, notes..."
            class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
        </div>

        
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Postal Code</label>
            <input type="text" name="postal_code" id="postal_code"
              value="<?php echo e(old('postal_code', $address->postal_code)); ?>"
              placeholder="e.g. 80361"
              class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
          </div>

          <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Set as Default</label>
            <select name="is_default" class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
              <option value="0" <?php echo e(old('is_default', $address->is_default) == 0 ? 'selected' : ''); ?>>No</option>
              <option value="1" <?php echo e(old('is_default', $address->is_default) == 1 ? 'selected' : ''); ?>>Yes</option>
            </select>
          </div>
        </div>

        
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Latitude</label>
            <input type="text" id="latitude" name="latitude"
              value="<?php echo e(old('latitude', $address->latitude)); ?>" readonly
              class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600 cursor-not-allowed dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Longitude</label>
            <input type="text" id="longitude" name="longitude"
              value="<?php echo e(old('longitude', $address->longitude)); ?>" readonly
              class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600 cursor-not-allowed dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400">
          </div>
        </div>

        
        <div>
          <div class="flex justify-between items-center mb-2">
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Select Location</label>
            <button type="button" id="findLocationBtn"
              class="px-3 py-2 flex items-center gap-2 bg-green-600 text-white text-xs rounded-lg hover:bg-green-700 transition focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0Z"/>
                <circle cx="12" cy="10" r="3"/>
              </svg>
              Find My Location
            </button>
          </div>
          <div id="map" class="w-full h-96 rounded-lg border border-gray-300 dark:border-gray-700 overflow-hidden"></div>
          <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
            Click on the map, drag the marker, search for a location, or use <strong>Find My Location</strong> button.
          </p>
        </div>

        
        <div class="pt-4 flex gap-3">
          <button type="submit"
            class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Update Address
          </button>
          <a href="<?php echo e(route('profile.addresses.index')); ?>"
            class="px-5 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm rounded-lg transition dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200">
            Cancel
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
  // Get initial coordinates from address or use default (Denpasar, Bali)
  const initialLat = parseFloat('<?php echo e($address->latitude); ?>') || -8.65;
  const initialLng = parseFloat('<?php echo e($address->longitude); ?>') || 115.2167;
  
  // Initialize map
  const mapEl = document.getElementById('map');
  const map = L.map(mapEl).setView([initialLat, initialLng], 13);
  
  // Add tile layer
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { 
    maxZoom: 19,
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  // Add draggable marker
  let marker = L.marker([initialLat, initialLng], { draggable: true }).addTo(map);

  // Function to update lat/lng inputs and reverse geocode
  const updateLocation = async (lat, lng) => {
    document.getElementById('latitude').value = lat.toFixed(8);
    document.getElementById('longitude').value = lng.toFixed(8);
    
    try {
      const res = await fetch(
        `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1&accept-language=id`
      );
      const data = await res.json();
      
      if (data.display_name) {
        document.getElementById('full_address').value = data.display_name;
      }
      if (data.address?.postcode) {
        document.getElementById('postal_code').value = data.address.postcode;
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
    const pos = e.target.getLatLng();
    updateLocation(pos.lat, pos.lng);
  });

  // Find My Location button
  document.getElementById('findLocationBtn').addEventListener('click', () => {
    if (!navigator.geolocation) {
      alert('Geolocation is not supported by your browser.');
      return;
    }

    // Add loading state
    const btn = document.getElementById('findLocationBtn');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<span class="animate-spin">⏳</span> Getting location...';
    btn.disabled = true;

    navigator.geolocation.getCurrentPosition(
      async (position) => {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;
        
        map.setView([lat, lng], 16);
        marker.setLatLng([lat, lng]);
        await updateLocation(lat, lng);

        // Reset button
        btn.innerHTML = originalText;
        btn.disabled = false;
      },
      (error) => {
        console.error('Geolocation error:', error);
        alert('Unable to get your location. Please make sure location permissions are enabled.');
        
        // Reset button
        btn.innerHTML = originalText;
        btn.disabled = false;
      },
      {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
      }
    );
  });

  // Add search box
  const searchContainer = document.createElement('div');
  searchContainer.className = 'leaflet-search-container';
  searchContainer.innerHTML = `
    <input type="text" class="leaflet-search-input" placeholder="Search location...">
    <ul class="leaflet-search-results"></ul>
  `;
  mapEl.appendChild(searchContainer);

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

    // Add loading state
    resultList.innerHTML = '<li class="leaflet-search-loading">Searching</li>';

    searchTimeout = setTimeout(async () => {
      try {
        const res = await fetch(
          `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&addressdetails=1&limit=5&accept-language=id`
        );
        const data = await res.json();
        
        if (data.length === 0) {
          resultList.innerHTML = '<li style="color: #9ca3af;">No results found</li>';
          return;
        }
        
        resultList.innerHTML = data.map(r =>
          `<li data-lat="${r.lat}" data-lon="${r.lon}" data-display="${r.display_name}">${r.display_name}</li>`
        ).join('');
      } catch (err) {
        console.error('Search error:', err);
        resultList.innerHTML = '<li style="color: #ef4444;">Search failed. Please try again.</li>';
      }
    }, 400);
  });

  // Handle search result click
  resultList.addEventListener('click', (e) => {
    if (e.target.tagName !== 'LI' || !e.target.dataset.lat) return;
    
    const { lat, lon, display } = e.target.dataset;
    const latNum = parseFloat(lat);
    const lonNum = parseFloat(lon);
    
    map.setView([latNum, lonNum], 16);
    marker.setLatLng([latNum, lonNum]);
    
    document.getElementById('latitude').value = latNum.toFixed(8);
    document.getElementById('longitude').value = lonNum.toFixed(8);
    document.getElementById('full_address').value = display;
    
    resultList.innerHTML = '';
    searchInput.value = display;
  });

  // Clear search results when clicking outside
  document.addEventListener('click', (e) => {
    if (!searchContainer.contains(e.target)) {
      resultList.innerHTML = '';
    }
  });

  // Fix map display
  setTimeout(() => {
    map.invalidateSize();
  }, 100);
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/profile/addresses/edit.blade.php ENDPATH**/ ?>