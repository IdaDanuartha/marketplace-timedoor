@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
  <h1 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Edit Profile</h1>

  {{-- Success / Error Message --}}
  @if(session('success'))
    <div class="p-3 rounded-lg bg-green-100 text-green-700 border border-green-200">
      {{ session('success') }}
    </div>
  @endif

  @if($errors->any())
    <div class="p-3 rounded-lg bg-red-100 text-red-700 border border-red-200">
      <ul class="list-disc list-inside">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    {{-- USER ACCOUNT --}}
    <div class="grid md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Username</label>
        <input type="text" name="username" value="{{ old('username', $user->username) }}"
          class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $user->email) }}"
          class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
      </div>
    </div>

    {{-- PASSWORD --}}
    <div class="grid md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">New Password</label>
        <input type="password" name="password"
          class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white"
          placeholder="Leave blank to keep current password">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Confirm Password</label>
        <input type="password" name="password_confirmation"
          class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white"
          placeholder="Confirm new password">
      </div>
    </div>

    {{-- PROFILE IMAGE (Dropzone Component) --}}
    <div>
      <label class="block text-sm font-medium mb-2">Profile Image</label>
      <div id="dropzone" 
           class="dropzone rounded-xl border border-dashed border-gray-300 bg-gray-50 p-7 lg:p-10
                  dark:border-gray-700 dark:bg-gray-900 cursor-pointer text-center">
        <input type="file" name="profile_image" id="fileInput" class="hidden" accept="image/*">
        
        {{-- Preview --}}
        <div id="preview" class="{{ $user->profile_image ? '' : 'hidden' }} mb-4 flex justify-center">
          <img id="previewImage"
               src="{{ $user->profile_image ? profile_image($user->profile_image) : '' }}"
               class="max-h-48 rounded-lg border dark:border-gray-700">
        </div>

        <div id="dz-message" onclick="document.getElementById('fileInput').click()">
          <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90">Drop or Browse</h4>
          <p class="text-sm text-gray-500">Upload PNG, JPG, WEBP, or SVG image</p>
        </div>
      </div>

      @if($user->profile_image)
        <a href="{{ profile_image($user->profile_image) }}" target="_blank"
          class="text-xs text-blue-500 hover:underline block mt-2">View Current Image</a>
      @endif

      @error('profile_image')
        <p class="mt-1 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
      @enderror
    </div>

    {{-- ROLE-SPECIFIC FIELDS --}}
    @if($user->admin)
      <div>
        <label class="block text-sm font-medium mb-1">Name</label>
        <input type="text" name="name" value="{{ old('name', $user->admin->name) }}"
          class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
      </div>
    @elseif($user->vendor)
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium mb-1">Vendor Name</label>
          <input type="text" name="name" value="{{ old('name', $user->vendor->name) }}"
            class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Address</label>
          <textarea name="address" rows="3"
            class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">{{ old('address', $user->vendor->address) }}</textarea>
        </div>
      </div>
    @elseif($user->customer)
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium mb-1">Customer Name</label>
          <input type="text" name="name" value="{{ old('name', $user->customer->name) }}"
            class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Phone</label>
          <input type="text" name="phone" value="{{ old('phone', $user->customer->phone) }}"
            class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
        </div>
      </div>
    @endif

    {{-- SUBMIT --}}
    <div class="text-right">
      <button type="submit"
        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
        Save Changes
      </button>
    </div>
  </form>
</div>
@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('fileInput');
  const previewContainer = document.getElementById('preview');
  const previewImage = document.getElementById('previewImage');
  const dropzone = document.getElementById('dropzone');

  dropzone.addEventListener('click', () => input.click());
  dropzone.addEventListener('dragover', e => {
    e.preventDefault();
    dropzone.classList.add('bg-blue-50', 'dark:bg-blue-900/20');
  });
  dropzone.addEventListener('dragleave', () => {
    dropzone.classList.remove('bg-blue-50', 'dark:bg-blue-900/20');
  });
  dropzone.addEventListener('drop', e => {
    e.preventDefault();
    input.files = e.dataTransfer.files;
    input.dispatchEvent(new Event('change'));
    dropzone.classList.remove('bg-blue-50', 'dark:bg-blue-900/20');
  });

  input.addEventListener('change', e => {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
      previewImage.src = e.target.result;
      previewContainer.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
  });
});
</script>
@endpush