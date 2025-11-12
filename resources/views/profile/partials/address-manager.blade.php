<div x-data="addressManager()" class="space-y-6">
  <template x-for="(address, index) in addresses" :key="index">
    <div class="rounded-xl border border-gray-200 dark:border-gray-800 p-5 space-y-4 relative bg-white dark:bg-gray-900/50">
      <div class="grid md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium mb-1">Label</label>
          <input type="text" x-model="address.label" :name="`addresses[${index}][label]`"
                 class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
        </div>

        <div class="flex items-center justify-between">
          <label class="block text-sm font-medium mb-1">Default</label>
          <input type="radio" name="default_address" :value="index" x-model="defaultIndex"
                 @change="setDefaultAddress(index)" class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Full Address</label>
        <textarea rows="2" x-model="address.full_address" :name="`addresses[${index}][full_address]`"
                  class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white"></textarea>
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Additional Info</label>
        <textarea rows="2" x-model="address.additional_information" :name="`addresses[${index}][additional_information]`"
                  class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white"></textarea>
      </div>

      <div class="grid md:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-medium mb-1">Postal Code</label>
          <input type="text" x-model="address.postal_code" :name="`addresses[${index}][postal_code]`"
                 class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Latitude</label>
          <input type="text" x-model="address.latitude" :name="`addresses[${index}][latitude]`"
                 class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Longitude</label>
          <input type="text" x-model="address.longitude" :name="`addresses[${index}][longitude]`"
                 class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
        </div>
      </div>

      <div class="rounded-xl overflow-hidden h-56 border border-gray-200 dark:border-gray-700">
        <div :id="`map-${index}`" class="w-full h-full"></div>
      </div>

      <div class="flex justify-end">
        <button type="button" @click="removeAddress(index)"
                class="text-sm text-red-600 hover:text-red-700">Remove</button>
      </div>
    </div>
  </template>

  <button type="button" @click="addAddress()" 
          class="px-4 py-2 text-sm bg-blue-600 text-white rounded-lg hover:bg-blue-700">
    + Add Address
  </button>
</div>

@push('js')
<script>
function addressManager() {
  const initialAddresses = {!! Js::from(
    $user->customer?->addresses->map(fn($a) => [
      'full_address' => $a->full_address,
      'additional_information' => $a->additional_information,
      'postal_code' => $a->postal_code,
      'latitude' => $a->latitude,
      'longitude' => $a->longitude,
      'label' => $a->label,
      'is_default' => (bool) $a->is_default,
    ]) ?? []
  ) !!};

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
    defaultIndex: initialAddresses.findIndex(a => a.is_default) || 0,
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
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 18 }).addTo(map);
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
        } catch (err) { console.error(err); }
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
      this.defaultIndex = i;
    }
  };
}
</script>
@endpush