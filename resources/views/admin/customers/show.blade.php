@extends('layouts.app')

@section('title', $customer->name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6" x-data="{ isModalOpen: false, title: '', deleteUrl: '' }" x-cloak>

  {{-- CUSTOMER PROFILE --}}
  <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3 p-6">
    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-5">
      <img src="{{ profile_image($customer->user->profile_image) }}" 
           class="w-24 h-24 rounded-full object-cover border dark:border-gray-700">
      <div class="text-center sm:text-left">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">{{ $customer->name }}</h2>
        <p class="text-gray-600 dark:text-gray-300 text-sm">{{ $customer->user->email }}</p>
        <p class="text-gray-600 dark:text-gray-300 text-sm">Phone: {{ $customer->phone ?? '-' }}</p>
      </div>
    </div>
  </div>

  {{-- ADDRESSES --}}
  <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3 p-6">
    <h3 class="text-lg font-medium text-gray-800 dark:text-white/90 mb-4">Addresses</h3>

    <div class="space-y-5">
      @forelse ($customer->addresses as $address)
        <div class="border rounded-xl p-5 relative overflow-hidden dark:border-gray-700 {{ $address->is_default ? 'bg-blue-50 dark:bg-blue-900/20' : 'bg-gray-50 dark:bg-gray-900/30' }}">
          <div class="flex justify-between items-start">
            <div>
              <p class="font-medium text-gray-800 dark:text-gray-100 mb-1">
                {{ $address->label ?? 'Home' }}
              </p>
              <p class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-line">
                {{ $address->full_address }}
              </p>
              @if ($address->additional_information)
                <p class="text-xs text-gray-500 mt-1 italic">
                  Note: {{ $address->additional_information }}
                </p>
              @endif
              <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                Postal Code: {{ $address->postal_code ?? '-' }}
              </p>
              <p class="text-xs text-gray-500 dark:text-gray-400">
                Lat: {{ $address->latitude ?? '-' }}, Lng: {{ $address->longitude ?? '-' }}
              </p>
            </div>

            @if ($address->is_default)
              <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 dark:bg-blue-800/50 dark:text-blue-300 rounded-md font-medium">
                Default
              </span>
            @endif
          </div>

          {{-- Mini Map --}}
          @if ($address->latitude && $address->longitude)
            <div class="mt-4 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 h-80" 
                 id="map-preview-{{ $loop->index }}"></div>
          @endif
        </div>
      @empty
        <p class="text-gray-500 text-sm">No addresses available.</p>
      @endforelse
    </div>
  </div>

  {{-- ACTION BUTTONS --}}
  <div class="flex justify-end gap-3">
    <a href="{{ route('customers.edit', $customer) }}" 
       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">Edit</a>
    <form action="{{ route('customers.destroy', $customer) }}" method="POST" 
          onsubmit="return confirm('Are you sure you want to delete this customer?')">
      @csrf @method('DELETE')
      <button 
        @click.prevent="
          event.stopPropagation();
          title = '{{ $customer->name }}';
          deleteUrl = '{{ route('customers.destroy', $customer) }}';
          isModalOpen = true
        " 
        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">Delete</button>
    </form>
  </div>

  <x-modal.modal-delete />
</div>

@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', () => {
  @foreach ($customer->addresses as $index => $address)
    @if ($address->latitude && $address->longitude)
      const map{{ $index }} = L.map('map-preview-{{ $index }}', {
        zoomControl: false,
        scrollWheelZoom: false,
        // dragging: false
      }).setView([{{ $address->latitude }}, {{ $address->longitude }}], 13);

      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18
      }).addTo(map{{ $index }});

      L.marker([{{ $address->latitude }}, {{ $address->longitude }}]).addTo(map{{ $index }});
    @endif
  @endforeach
});
</script>
@endpush