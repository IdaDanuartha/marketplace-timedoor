@extends('layouts.app')

@section('title', 'Vendor Details')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
  <div class="col-span-12">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
      {{-- Header --}}
      <div class="px-5 py-4 sm:px-6 sm:py-5 flex items-center justify-between border-b border-gray-100 dark:border-gray-800">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Vendor Details</h3>
        <div class="flex items-center gap-3">
          <a href="{{ route('vendors.edit', $vendor) }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Edit
          </a>
          <a href="{{ route('vendors.index') }}" class="text-sm text-blue-600 hover:underline">← Back</a>
        </div>
      </div>

      {{-- Body --}}
      <div class="p-6 space-y-8">
        {{-- Profile Image --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
          <div class="w-32 h-32 overflow-hidden rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 flex items-center justify-center">
            @if ($vendor->user->profile_image)
              <img src="{{ profile_image($vendor->user->profile_image) }}" alt="{{ $vendor->name }}" class="w-full h-full object-cover">
            @else
              <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.847.607 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
            @endif
          </div>

          <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white">{{ $vendor->name }}</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Vendor ID: #{{ $vendor->id }}</p>
            <div class="mt-3">
              @if ($vendor->is_approved)
                <span class="px-3 py-1.5 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300">
                  Approved
                </span>
              @else
                <span class="px-3 py-1.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300">
                  Pending Approval
                </span>
              @endif
            </div>
          </div>
        </div>

        {{-- User Info --}}
        <div class="rounded-xl border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/40 p-5">
          <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">User Information</h4>
          <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
            <div>
              <dt class="font-medium text-gray-600 dark:text-gray-400">Username</dt>
              <dd class="text-gray-800 dark:text-gray-200">{{ $vendor->user->username }}</dd>
            </div>
            <div>
              <dt class="font-medium text-gray-600 dark:text-gray-400">Email</dt>
              <dd class="text-gray-800 dark:text-gray-200">{{ $vendor->user->email }}</dd>
            </div>
            <div>
              <dt class="font-medium text-gray-600 dark:text-gray-400">Created At</dt>
              <dd class="text-gray-800 dark:text-gray-200">{{ $vendor->created_at->format('d M Y, H:i') }}</dd>
            </div>
            <div>
              <dt class="font-medium text-gray-600 dark:text-gray-400">Last Updated</dt>
              <dd class="text-gray-800 dark:text-gray-200">{{ $vendor->updated_at->format('d M Y, H:i') }}</dd>
            </div>
          </dl>
        </div>

        {{-- Address --}}
        <div class="rounded-xl border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/40 p-5">
          <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Address</h4>
          <p class="text-gray-800 dark:text-gray-200">
            {{ $vendor->address ? $vendor->address : 'No address provided.' }}
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection