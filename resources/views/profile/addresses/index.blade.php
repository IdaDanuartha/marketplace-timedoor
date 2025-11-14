@extends('layouts.app')

@section('title', 'My Addresses')

@section('content')
<div class="max-w-4xl mx-auto space-y-8" x-data="{ openDelete: false, deleteUrl: '' }">
  {{-- Breadcrumb --}}
  <nav class="text-sm text-gray-500">
    <ol class="flex items-center space-x-2">
      <li><a href="{{ route('dashboard.index') }}" class="hover:underline">Dashboard</a></li>
      <li>/</li>
      <li class="text-gray-700 dark:text-gray-300">My Addresses</li>
    </ol>
  </nav>

  <div class="flex items-center justify-between">
    <h1 class="text-xl font-semibold text-gray-800 dark:text-white">My Addresses</h1>
    <a href="{{ route('profile.addresses.create') }}" 
      class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg">
      + Add Address
    </a>
  </div>

  {{-- Alert --}}
  @if(session('success'))
    <div class="p-3 bg-green-100 border border-green-300 text-green-800 rounded-lg">
      {{ session('success') }}
    </div>
  @endif
  @if($errors->any())
    <div class="p-3 bg-red-100 border border-red-300 text-red-800 rounded-lg">
      {{ $errors->first() }}
    </div>
  @endif

  {{-- Address list --}}
  <div class="space-y-4">
    @forelse ($addresses as $address)
      <div class="p-5 rounded-xl border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-900">
        <div class="flex justify-between items-center">
          <div>
            <h3 class="font-semibold text-gray-900 dark:text-white flex items-center gap-2">
              {{ $address->label }}
              @if($address->is_default)
                <span class="px-2 py-0.5 text-xs rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                  Default
                </span>
              @endif
            </h3>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $address->full_address }}</p>
            @if($address->additional_information)
              <p class="text-xs text-gray-500 dark:text-gray-500">{{ $address->additional_information }}</p>
            @endif
          </div>
          <div class="flex items-center gap-2">
            <a href="{{ route('profile.addresses.show', $address->id) }}" 
              class="text-gray-600 hover:text-blue-600 dark:text-gray-300 dark:hover:text-blue-400 text-sm">View</a>
            <a href="{{ route('profile.addresses.edit', $address->id) }}" 
              class="text-gray-600 hover:text-green-600 dark:text-gray-300 dark:hover:text-green-400 text-sm">Edit</a>
            <button @click.prevent="
                      event.stopPropagation();
                      title = '{{ $address->label }}'; 
                      deleteUrl = '{{ route('profile.addresses.destroy', $address->id) }}'; 
                      isModalOpen = true
                    "
              class="text-red-500 hover:text-red-600 text-sm">Delete</button>
          </div>
        </div>
      </div>
    @empty
      <p class="text-gray-500 dark:text-gray-400 text-sm">You don’t have any addresses yet.</p>
    @endforelse
  </div>

  <!-- Delete Modal -->
<x-modal.modal-delete />
</div>
@endsection