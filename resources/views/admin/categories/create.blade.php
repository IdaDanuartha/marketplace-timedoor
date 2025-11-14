@extends('layouts.app')

@section('title', 'Add Category')

@section('content')
<nav class="mb-6 text-sm text-gray-500">
  <ol class="flex items-center space-x-2">
    <li><a href="{{ route('dashboard.index') }}" class="hover:underline">Dashboard</a></li>
    <li>/</li>
    <li><a href="{{ route('categories.index') }}" class="hover:underline">Categories</a></li>
    <li>/</li>
    <li class="text-gray-700 dark:text-gray-300">Create</li>
  </ol>
</nav>

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
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">
          Create Category
        </h3>
        <a href="{{ route('categories.index') }}" 
           class="text-sm text-blue-600 hover:underline">← Back</a>
      </div>

      <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
        <form action="{{ route('categories.store') }}" method="POST">
          @csrf

          {{-- Name --}}
          <div class="mb-4">
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              Name
            </label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter category name"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90" required>
            @error('name')
              <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- Parent Category --}}
          <div class="mb-4">
            <label class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
              Parent Category (optional)
            </label>
            <select name="parent_id"
              class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
              <option value="">None</option>
              @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('parent_id') == $category->id ? 'selected' : '' }}>
                  {{ $category->name }}
                </option>
              @endforeach
            </select>
          </div>

          {{-- Submit --}}
          <div class="pt-4">
            <button type="submit"
              class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition">
              Save Category
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection