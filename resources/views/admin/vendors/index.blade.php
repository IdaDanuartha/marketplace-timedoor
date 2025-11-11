@extends('layouts.app')

@section('title', 'Vendors')

@section('content')
<div 
  x-data="{ isModalOpen: false, title: '', deleteUrl: '' }"
  x-cloak
>
  {{-- Breadcrumb --}}
  <nav class="mb-6 text-sm text-gray-500">
    <ol class="flex items-center space-x-2">
      <li><a href="{{ route('dashboard.index') }}" class="hover:underline">Dashboard</a></li>
      <li>/</li>
      <li class="text-gray-700 dark:text-gray-300">Vendors</li>
    </ol>
  </nav>

  {{-- Flash messages --}}
  @if (session('success'))
    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700 dark:border-green-700/40 dark:bg-green-900/30 dark:text-green-300">
      <div class="flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        <span>{{ session('success') }}</span>
      </div>
    </div>
  @endif

  @if ($errors->any())
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700 dark:border-red-700/40 dark:bg-red-900/30 dark:text-red-300">
      <ul class="space-y-1 list-disc pl-4">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Filters --}}
  <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-3">
    <form method="GET" class="flex items-center gap-2 sm:flex-nowrap flex-wrap">
      <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search vendor..."
        class="border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 w-64 bg-white dark:bg-gray-900 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

      <select name="status" class="select2">
        <option value="">All Status</option>
        <option value="1" {{ ($filters['status'] ?? '') === '1' ? 'selected' : '' }}>Approved</option>
        <option value="0" {{ ($filters['status'] ?? '') === '0' ? 'selected' : '' }}>Pending</option>
      </select>

      <button class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Filter</button>
    </form>

    <a href="{{ route('vendors.create') }}" 
        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
      + Add Vendor
    </a>
  </div>

  {{-- Table --}}
  <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900/50">
    <div class="max-w-full overflow-x-auto">
      <table class="min-w-full text-left text-sm">
        <thead class="border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/30">
          <tr>
            {{-- Sortable columns --}}
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">
              <a href="{{ route('vendors.index', array_merge(request()->query(), [
                'sort_by' => 'name',
                'sort_dir' => ($filters['sort_by'] ?? '') === 'name' && ($filters['sort_dir'] ?? '') === 'asc' ? 'desc' : 'asc'
              ])) }}" class="flex items-center gap-1 hover:underline">
                Vendor Name
                @if(($filters['sort_by'] ?? '') === 'name')
                  @if(($filters['sort_dir'] ?? '') === 'asc')
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                  @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                  @endif
                @endif
              </a>
            </th>

            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Username</th>

            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">
              <a href="{{ route('vendors.index', array_merge(request()->query(), [
                'sort_by' => 'email',
                'sort_dir' => ($filters['sort_by'] ?? '') === 'email' && ($filters['sort_dir'] ?? '') === 'asc' ? 'desc' : 'asc'
              ])) }}" class="flex items-center gap-1 hover:underline">
                Email
                @if(($filters['sort_by'] ?? '') === 'email')
                  @if(($filters['sort_dir'] ?? '') === 'asc')
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                  @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                  @endif
                @endif
              </a>
            </th>

            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300 text-center">
              <a href="{{ route('vendors.index', array_merge(request()->query(), [
                'sort_by' => 'is_approved',
                'sort_dir' => ($filters['sort_by'] ?? '') === 'is_approved' && ($filters['sort_dir'] ?? '') === 'asc' ? 'desc' : 'asc'
              ])) }}" class="flex items-center justify-center gap-1 hover:underline">
                Approved
                @if(($filters['sort_by'] ?? '') === 'is_approved')
                  @if(($filters['sort_dir'] ?? '') === 'asc')
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                  @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                  @endif
                @endif
              </a>
            </th>

            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
          @forelse ($vendors as $vendor)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 cursor-pointer" 
                onclick="window.location='{{ route('vendors.show', $vendor) }}'">
              <td class="px-5 py-3 text-gray-800 dark:text-gray-200 font-semibold">{{ $vendor->name }}</td>
              <td class="px-5 py-3 text-gray-700 dark:text-gray-300">{{ $vendor->user->username }}</td>
              <td class="px-5 py-3 text-gray-700 dark:text-gray-300">{{ $vendor->user->email }}</td>
              <td class="px-5 py-3 text-center">
                @if ($vendor->is_approved)
                  <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300">
                    Approved
                  </span>
                @else
                  <span class="px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300">
                    Pending
                  </span>
                @endif
              </td>
              <td class="px-5 py-3 text-right">
                <a href="{{ route('vendors.edit', $vendor) }}" onclick="event.stopPropagation()"
                  class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-400 font-medium transition">
                  Edit
                </a>
                <button 
                  @click.prevent="
                    event.stopPropagation();
                    title = '{{ $vendor->name }}'; 
                    deleteUrl = '{{ route('vendors.destroy', $vendor) }}'; 
                    isModalOpen = true
                  "
                  class="text-red-600 hover:text-red-700 dark:hover:text-red-400 ml-3 font-medium transition">
                  Delete
                </button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-5 py-6 text-center text-gray-500 dark:text-gray-400">
                No vendors found.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="p-4">
      {{ $vendors->appends(request()->query())->links() }}
    </div>
  </div>

  {{-- Delete Modal --}}
  <x-modal.modal-delete />
</div>
@endsection

@push('js')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    $('.select2').select2({
      width: '100%',
      minimumResultsForSearch: 0,
    });
  });
</script>
@endpush