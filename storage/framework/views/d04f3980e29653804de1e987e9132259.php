<?php $__env->startSection('title', 'Add New Address'); ?>

<?php $__env->startSection('content'); ?>
<nav class="text-sm text-gray-500 mb-5">
  <ol class="flex items-center space-x-2">
    <li><a href="<?php echo e(route('dashboard.index')); ?>" class="hover:underline">Dashboard</a></li>
    <li>/</li>
    <li><a href="<?php echo e(route('profile.addresses.index')); ?>" class="hover:underline">My Addresses</a></li>
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
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Add New Address</h3>
        <a href="<?php echo e(route('profile.addresses.index')); ?>" class="text-sm text-blue-600 hover:underline">← Back</a>
      </div>

      <form action="<?php echo e(route('profile.addresses.store')); ?>" method="POST" class="border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800 space-y-6">
        <?php echo csrf_field(); ?>

        
        <div>
          <label class="block text-sm font-medium mb-1">Label</label>
          <select name="label" class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
            <option value="Home">Home</option>
            <option value="Work">Work</option>
            <option value="Office">Office</option>
            <option value="Other">Other</option>
          </select>
        </div>

        
        <div>
          <label class="block text-sm font-medium mb-1">Full Address</label>
          <textarea name="full_address" id="full_address" rows="3"
            class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white"
            placeholder="Click on the map or use 'Find My Location'" required></textarea>
        </div>

        
        <div>
          <label class="block text-sm font-medium mb-1">Additional Information</label>
          <input type="text" name="additional_information" placeholder="Apartment number, building name, etc."
            class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
        </div>

        
        <div class="grid md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1">Postal Code</label>
            <input type="text" name="postal_code" id="postal_code"
              class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Set as Default</label>
            <select name="is_default" class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
              <option value="0">No</option>
              <option value="1">Yes</option>
            </select>
          </div>
        </div>

        
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium mb-1">Latitude</label>
            <input type="text" id="latitude" name="latitude" readonly
              class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600 cursor-not-allowed dark:bg-gray-800 dark:text-gray-400">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Longitude</label>
            <input type="text" id="longitude" name="longitude" readonly
              class="w-full border rounded-lg px-3 py-2 bg-gray-100 text-gray-600 cursor-not-allowed dark:bg-gray-800 dark:text-gray-400">
          </div>
        </div>

        
        <div>
          <div class="flex justify-between items-center mb-2">
            <label class="block text-sm font-medium">Select Location</label>
            <button type="button" id="findLocationBtn"
              class="px-3 py-2 flex items-center gap-2 bg-green-600 text-white text-xs rounded-lg hover:bg-green-700 transition">
              <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                class="lucide lucide-map-pin">
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

        
        <div class="pt-4">
          <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition">
            Save Address
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const mapEl = document.getElementById('map');
  const map = L.map(mapEl).setView([-8.65, 115.2167], 12);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);

  let marker = L.marker([-8.65, 115.2167], { draggable: true }).addTo(map);

  const updateLocation = async (lat, lng) => {
    document.getElementById('latitude').value = lat.toFixed(8);
    document.getElementById('longitude').value = lng.toFixed(8);
    try {
      const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1&accept-language=id`);
      const data = await res.json();
      if (data.display_name) document.getElementById('full_address').value = data.display_name;
      if (data.address?.postcode) document.getElementById('postal_code').value = data.address.postcode;
    } catch (err) { console.error('Reverse geocode error:', err); }
  };

  map.on('click', (e) => {
    marker.setLatLng(e.latlng);
    updateLocation(e.latlng.lat, e.latlng.lng);
  });
  marker.on('dragend', (e) => {
    const pos = e.target.getLatLng();
    updateLocation(pos.lat, pos.lng);
  });

  // === Find My Location ===
  document.getElementById('findLocationBtn').addEventListener('click', () => {
    if (!navigator.geolocation) {
      alert('Geolocation tidak didukung oleh browser kamu.');
      return;
    }
    navigator.geolocation.getCurrentPosition(async (pos) => {
      const lat = pos.coords.latitude;
      const lng = pos.coords.longitude;
      map.setView([lat, lng], 15);
      marker.setLatLng([lat, lng]);
      await updateLocation(lat, lng);
    }, (err) => {
      console.error(err);
      alert('Gagal mendapatkan lokasi. Pastikan izin lokasi aktif.');
    });
  });

  // === Add Search Box ===
  const searchContainer = document.createElement('div');
  searchContainer.className = 'leaflet-search-container';
  searchContainer.innerHTML = `
    <input type="text" class="leaflet-search-input" placeholder="Cari lokasi...">
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
    if (!query) return resultList.innerHTML = '';

    searchTimeout = setTimeout(async () => {
      try {
        const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&addressdetails=1&limit=5&accept-language=id`);
        const data = await res.json();
        resultList.innerHTML = data.map(r =>
          `<li data-lat="${r.lat}" data-lon="${r.lon}" data-display="${r.display_name}">${r.display_name}</li>`
        ).join('');
      } catch {
        resultList.innerHTML = '<li>Gagal mencari lokasi.</li>';
      }
    }, 400);
  });

  resultList.addEventListener('click', (e) => {
    if (e.target.tagName !== 'LI') return;
    const { lat, lon, display } = e.target.dataset;
    map.setView([lat, lon], 16);
    marker.setLatLng([lat, lon]);
    document.getElementById('latitude').value = parseFloat(lat).toFixed(8);
    document.getElementById('longitude').value = parseFloat(lon).toFixed(8);
    document.getElementById('full_address').value = display;
    resultList.innerHTML = '';
  });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/profile/addresses/create.blade.php ENDPATH**/ ?>