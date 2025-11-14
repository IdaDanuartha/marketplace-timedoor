@extends('layouts.app')

@section('title', 'Address Detail')

@section('content')
<nav class="text-sm text-gray-500 mb-5">
  <ol class="flex items-center space-x-2">
    <li><a href="{{ route('dashboard.index') }}" class="hover:underline">Dashboard</a></li>
    <li>/</li>
    <li><a href="{{ route('profile.addresses.index') }}" class="hover:underline">My Addresses</a></li>
    <li>/</li>
    <li class="text-gray-700 dark:text-gray-300">Detail</li>
  </ol>
</nav>

<div class="max-w-6xl mx-auto space-y-6">
  <div class="flex justify-between items-center">
    <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Address Detail</h1>
    <a href="{{ route('profile.addresses.index') }}" class="text-sm text-blue-600 hover:underline">← Back</a>
  </div>

  <div class="rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900 p-5 space-y-3">
    <p><span class="font-semibold">Label:</span> {{ $address->label }}</p>
    <p><span class="font-semibold">Full Address:</span> {{ $address->full_address }}</p>
    @if($address->additional_information)
      <p><span class="font-semibold">Additional Info:</span> {{ $address->additional_information }}</p>
    @endif
    <p><span class="font-semibold">Postal Code:</span> {{ $address->postal_code ?? '-' }}</p>
    <p><span class="font-semibold">Coordinates:</span> 
      {{ $address->latitude ?? '-' }}, {{ $address->longitude ?? '-' }}
    </p>
    @if($address->is_default)
      <p><span class="px-2 py-0.5 text-xs bg-blue-100 text-blue-700 rounded-full">Default Address</span></p>
    @endif
  </div>

  {{-- MAP --}}
  @if($address->latitude && $address->longitude)
  <div>
    <h2 class="text-lg font-medium text-gray-800 dark:text-white mb-2">Location Map</h2>
    <div id="map" class="w-full h-80 rounded-lg border border-gray-300 dark:border-gray-700 overflow-hidden"></div>
  </div>
  @endif
</div>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const lat = {{ $address->latitude ?? 'null' }};
  const lng = {{ $address->longitude ?? 'null' }};

  if (!lat || !lng) return;

  const map = L.map('map').setView([lat, lng], 15);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18,
    attribution: '© OpenStreetMap contributors'
  }).addTo(map);

  const marker = L.marker([lat, lng]).addTo(map);
  marker.bindPopup(`<b>{{ $address->label }}</b><br>{{ $address->full_address }}`).openPopup();
});
</script>
@endpush