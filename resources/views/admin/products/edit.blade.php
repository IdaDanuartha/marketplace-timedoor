@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
@php
  $user = auth()->user();
  $isVendor = $user->vendor ? true : false;
@endphp

<div class="grid grid-cols-12 gap-4 md:gap-6">
  <div class="col-span-12">
    {{-- Flash & Errors --}}
    @if ($errors->any())
      <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700 dark:border-red-700/40 dark:bg-red-900/30 dark:text-red-300">
        <ul class="list-disc pl-5 space-y-1">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
      <div class="px-5 py-4 sm:px-6 sm:py-5 flex items-center justify-between">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Edit Product</h3>
        <a href="{{ route('products.index') }}" class="text-sm text-blue-600 hover:underline">← Back</a>
      </div>

      <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          {{-- Basic Inputs --}}
          <div class="grid grid-cols-2 gap-4">
            {{-- Name --}}
            <div>
              <label class="block text-sm font-medium mb-1">Name</label>
              <input type="text" name="name" value="{{ old('name', $product->name) }}"
                placeholder="Enter product name"
                class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white @error('name') border-red-500 @enderror" required>
              @error('name')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- Price --}}
            <div>
              <label class="block text-sm font-medium mb-1">Price</label>
              <input type="number" name="price" value="{{ old('price', $product->price) }}"
                placeholder="Enter product price"
                class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white @error('price') border-red-500 @enderror" required>
              @error('price')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- Stock --}}
            <div>
              <label class="block text-sm font-medium mb-1">Stock</label>
              <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                placeholder="Enter product stock"
                class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white @error('stock') border-red-500 @enderror" required>
              @error('stock')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- Category --}}
            <div>
              <label class="block text-sm font-medium mb-1">Category</label>
              <select name="category_id" class="select2 w-full @error('category_id') border-red-500 @enderror" required>
                <option value="">Select Category</option>
                @include('admin.products.partials.category-options', [
                  'categories' => $categories,
                  'depth' => 0,
                  'selectedCategory' => $product->category_id,
                ])
              </select>
              @error('category_id')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
              @enderror
            </div>

            {{-- Vendor (Admin only) --}}
            @unless($isVendor)
              <div>
                <label class="block text-sm font-medium mb-1">Vendor</label>
                <select name="vendor_id" class="select2 w-full @error('vendor_id') border-red-500 @enderror" required>
                  <option value="">Select Vendor</option>
                  @foreach ($vendors as $vendor)
                    <option value="{{ $vendor->id }}" {{ $product->vendor_id == $vendor->id ? 'selected' : '' }}>
                      {{ $vendor->name }}
                    </option>
                  @endforeach
                </select>
                @error('vendor_id')
                  <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
              </div>
            @else
              <input type="hidden" name="vendor_id" value="{{ $user->vendor->id }}">
            @endunless

            {{-- Status --}}
            <div>
              <label class="block text-sm font-medium mb-1">Status</label>
              <select name="status" class="select2 w-full @error('status') border-red-500 @enderror" required>
                @foreach (\App\Enum\ProductStatus::cases() as $case)
                  <option value="{{ $case->name }}"
                    {{ old('status', $product->status->name ?? \App\Enum\ProductStatus::ACTIVE->name) === $case->name ? 'selected' : '' }}>
                    {{ $case->label() }}
                  </option>
                @endforeach
              </select>
              @error('status')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
              @enderror
            </div>
          </div>

          {{-- Description --}}
          <div class="my-4">
            <label class="block text-sm font-medium mb-2">Description</label>
            <textarea name="description" id="editor" rows="6">{{ old('description', $product->description) }}</textarea>
            @error('description')
              <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- Image Upload --}}
          <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
            <div class="px-5 py-4 sm:px-6 sm:py-5">
              <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Product Image</h3>
            </div>

            <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
              @if ($product->image_path)
                <div class="mb-4 text-center">
                  <img src="{{ profile_image($product->image_path) }}"
                       alt="Current Image"
                       class="max-h-48 mx-auto rounded-lg border">
                  <p class="text-sm text-gray-500 mt-2">Current Image</p>
                </div>
              @endif

              <div id="product-dropzone"
                   class="dropzone rounded-xl border border-dashed border-gray-300 bg-gray-50 p-7 lg:p-10 dark:border-gray-700 dark:bg-gray-900">
                <input type="file" name="image_path" id="fileInput" class="hidden" accept="image/*">
                <div id="newPreview" class="flex justify-center mb-4 hidden">
                  <img id="previewImage" class="max-h-48 rounded-lg border" />
                </div>
                <div id="dz-message" class="dz-message text-center cursor-pointer"
                     onclick="document.getElementById('fileInput').click()">
                  <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90">Drop or Browse</h4>
                  <p class="text-sm text-gray-500">Drag your PNG, JPG, WebP, or SVG image here</p>
                </div>
              </div>
            </div>
          </div>

          {{-- Submit --}}
          <div class="pt-4 flex justify-between items-center">
            <div class="text-sm text-gray-500 dark:text-gray-400">
              @if($isVendor)
                <span>This product belongs to your vendor account.</span>
              @endif
            </div>
            <button type="submit"
              class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition">
              Update Product
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
  // === Image Preview ===
  const fileInput = document.getElementById('fileInput');
  const newPreview = document.getElementById('newPreview');
  const previewImage = document.getElementById('previewImage');

  fileInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = () => {
        previewImage.src = reader.result;
        newPreview.classList.remove('hidden');
      };
      reader.readAsDataURL(file);
    }
  });

  // === Select2 Init ===
  document.addEventListener('DOMContentLoaded', () => {
    $('.select2').select2({
      width: '100%',
      minimumResultsForSearch: 0,
      dropdownCssClass: 'text-sm'
    });
  });

  // === TinyMCE Init ===
  tinymce.init({
    selector: '#editor',
    height: 300,
    menubar: false,
    plugins: 'lists link image table code',
    toolbar: 'undo redo | bold italic underline | bullist numlist | link image',
    content_style: `
      body { font-family: Inter, sans-serif; font-size: 14px; }
      .dark & { color: #e5e7eb; background: #111827; }
    `
  });
</script>
@endpush