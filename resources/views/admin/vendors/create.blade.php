@extends('layouts.app')

@section('title', 'Create Vendor')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
  <div class="col-span-12">
    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
      <div class="px-5 py-4 sm:px-6 sm:py-5 flex items-center justify-between">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Create Vendor</h3>
        <a href="{{ route('vendors.index') }}" class="text-sm text-blue-600 hover:underline">← Back</a>
      </div>

      <div class="border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
        <form action="{{ route('vendors.store') }}" method="POST" enctype="multipart/form-data" x-data="{ switcherToggle: true }">
          @csrf

          <div class="grid grid-cols-2 gap-4">
            {{-- Vendor Name --}}
            <div>
              <label class="block text-sm font-medium mb-1">Vendor Name</label>
              <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white" placeholder="Enter vendor name" required>
              @error('name') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Username --}}
            <div>
              <label class="block text-sm font-medium mb-1">Username</label>
              <input type="text" name="username" value="{{ old('username') }}" class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white" placeholder="Enter username" required>
              @error('username') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Email --}}
            <div>
              <label class="block text-sm font-medium mb-1">Email</label>
              <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white" placeholder="Enter email" required>
              @error('email') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Password --}}
            <div>
              <label class="block text-sm font-medium mb-1">Password</label>
              <input type="password" name="password" class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white" placeholder="Enter password" required>
              @error('password') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Image Upload Section --}}
            <div
              class="rounded-2xl col-span-2 border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3 mt-3"
            >
              <div class="px-5 py-4 sm:px-6 sm:py-5">
                <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Profile Image</h3>
              </div>

              <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
                <div
                  class="dropzone rounded-xl border border-dashed border-gray-300 bg-gray-50 p-7 lg:p-10 dark:border-gray-700 dark:bg-gray-900"
                  id="vendor-dropzone"
                >
                  <input type="file" name="profile_image" id="fileInput" class="hidden" accept="image/*">
                  <div id="preview" class="flex justify-center mb-4 {{ isset($vendor) && $vendor->user->profile_image ? '' : 'hidden' }}">
                    <img id="previewImage" 
                        src="{{ isset($vendor) && $vendor->user->profile_image ? asset('storage/'.$vendor->user->profile_image) : '' }}" 
                        class="max-h-48 rounded-lg border" />
                  </div>
                  <div id="dz-message" class="dz-message text-center cursor-pointer"
                      onclick="document.getElementById('fileInput').click()">
                    <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90">Drop or Browse</h4>
                    <p class="text-sm text-gray-500">Drag your PNG, JPG, WebP, or SVG image here</p>
                  </div>
                </div>
              </div>
            </div>


            {{-- Address --}}
            <div class="col-span-2">
              <label class="block text-sm font-medium mb-1">Address</label>
              <textarea name="address" rows="3" class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white" placeholder="Enter address">{{ old('address') }}</textarea>
              @error('address') <p class="text-sm text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Approved Toggle --}}
            <div class="col-span-2 flex items-center gap-3 mt-2">
              <label for="toggle1" class="flex cursor-pointer items-center gap-3 text-sm font-medium text-gray-700 select-none dark:text-gray-400">
                <div class="relative">
                  <input type="checkbox" id="toggle1" name="is_approved" value="1" class="sr-only" @change="switcherToggle = !switcherToggle">
                  <div class="block h-6 w-11 rounded-full" :class="switcherToggle ? 'bg-blue-600 dark:bg-blue-500' : 'bg-gray-200 dark:bg-white/10'"></div>
                  <div class="absolute top-0.5 left-0.5 h-5 w-5 rounded-full bg-white shadow transition-transform" :class="switcherToggle ? 'translate-x-full' : 'translate-x-0'"></div>
                </div>
                Approved
              </label>
            </div>
          </div>

          <div class="pt-4">
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition">
              Save Vendor
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
  function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = () => {
        document.getElementById('previewImage').src = reader.result;
        document.getElementById('preview').classList.remove('hidden');
      };
      reader.readAsDataURL(file);
    }
  }

  document.getElementById('fileInput').addEventListener('change', e => {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = () => {
        const img = document.getElementById('previewImage');
        img.src = reader.result;
        document.getElementById('preview').classList.remove('hidden');
      };
      reader.readAsDataURL(file);
    }
  });
</script>
@endpush