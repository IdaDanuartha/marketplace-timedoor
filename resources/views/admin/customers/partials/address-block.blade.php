<div class="rounded-xl border border-gray-200 dark:border-gray-700 p-5 space-y-4">

  {{-- Full Address --}}
  <div>
    <label class="block text-sm font-medium mb-1">Full Address</label>
    <textarea x-model="address.full_address" 
      :name="`addresses[${index}][full_address]`"
      rows="3"
      placeholder="Enter full address" 
      class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white" 
      required></textarea>
  </div>

  {{-- Additional Info & Label --}}
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
      <select x-model="address.label" 
              :name="`addresses[${index}][label]`"
              class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
        <option value="Home">Home</option>
        <option value="Work">Work</option>
        <option value="Office">Office</option>
        <option value="Other">Other</option>
      </select>
    </div>
  </div>

  {{-- Postal Code --}}
  <div>
    <label class="block text-sm font-medium mb-1">Postal Code</label>
    <input x-model="address.postal_code" 
      :name="`addresses[${index}][postal_code]`"
      placeholder="e.g. 80361"
      class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white"
      required>
  </div>

  {{-- Map Section --}}
  <div>
    <div class="flex justify-between items-center mb-2">
      <label class="block text-sm font-medium">Select Location</label>
      <button type="button"
        @click="findMyLocation(index)"
        class="px-3 py-2 flex items-center gap-2 bg-green-600 text-white text-xs rounded-lg hover:bg-green-700">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pinned"><path d="M18 8c0 3.613-3.869 7.429-5.393 8.795a1 1 0 0 1-1.214 0C9.87 15.429 6 11.613 6 8a6 6 0 0 1 12 0"/><circle cx="12" cy="8" r="2"/><path d="M8.714 14h-3.71a1 1 0 0 0-.948.683l-2.004 6A1 1 0 0 0 3 22h18a1 1 0 0 0 .948-1.316l-2-6a1 1 0 0 0-.949-.684h-3.712"/></svg>
        Find My Location
      </button>
    </div>
    <div 
      class="w-full h-96 rounded-lg border border-gray-300 dark:border-gray-700 overflow-hidden"
      :id="`map-${index}`"
      x-init="$nextTick(() => initMap(index))"
    ></div>
  </div>

  {{-- Lat & Long --}}
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

  {{-- Default Toggle --}}
  <div class="flex items-center justify-between">
    <label class="flex cursor-pointer items-center gap-3 text-sm font-medium text-gray-700 dark:text-gray-300 select-none">
      <div class="relative">
        <input type="hidden" :name="`addresses[${index}][is_default]`" :value="address.is_default ? 1 : 0">
        <input type="checkbox" class="sr-only" x-model="address.is_default" @change="setDefaultAddress(index)">
        <div class="block h-6 w-11 rounded-full transition-colors"
            :class="address.is_default ? 'bg-blue-600 dark:bg-blue-500' : 'bg-gray-200 dark:bg-gray-700'"></div>
        <div :class="address.is_default ? 'translate-x-full' : 'translate-x-0'"
            class="absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white shadow transform transition duration-200 ease-in-out"></div>
      </div>
      <span>Default Address</span>
    </label>
  </div>

  {{-- Remove --}}
  <button type="button" @click="removeAddress(index)" 
    x-show="addresses.length > 1" 
    class="text-red-600 text-sm mt-2 hover:underline">Remove Address</button>
</div>