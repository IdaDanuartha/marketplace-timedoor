@extends('layouts.app')

@section('title', 'Customers')

@section('content')
<div x-data="{ isModalOpen: false, title: '', deleteUrl: '' }" x-cloak>
  {{-- Breadcrumb --}}
  <nav class="mb-6 text-sm text-gray-500">
    <ol class="flex items-center space-x-2">
      <li><a href="{{ route('dashboard.index') }}" class="hover:underline">Dashboard</a></li>
      <li>/</li>
      <li class="text-gray-700 dark:text-gray-300">Customers</li>
    </ol>
  </nav>

  {{-- Flash --}}
  @if (session('success'))
    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700 dark:border-green-700/40 dark:bg-green-900/30 dark:text-green-300">
      {{ session('success') }}
    </div>
  @endif

  {{-- Search --}}
  <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-3">
    <form method="GET" class="flex items-center gap-2">
      <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Search customer..."
        class="border border-gray-300 dark:border-gray-700 rounded-lg px-3 py-2 w-64 bg-white dark:bg-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-blue-500">
      <button class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Search</button>
    </form>
    <a href="{{ route('customers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">+ Add Customer</a>
  </div>

  {{-- Table --}}
  <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-900/50">
    <div class="max-w-full overflow-x-auto">
      <table class="min-w-full text-left text-sm">
        <thead class="border-b border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/30">
          <tr>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Name</th>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Username</th>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Email</th>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300">Phone</th>
            <th class="px-5 py-3 font-medium text-gray-600 dark:text-gray-300 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
          @forelse ($customers as $customer)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 cursor-pointer"
                onclick="window.location='{{ route('customers.show', $customer) }}'">
              <td class="px-5 py-3 text-gray-800 dark:text-gray-200 font-semibold">{{ $customer->name }}</td>
              <td class="px-5 py-3 text-gray-700 dark:text-gray-300">{{ $customer->user->username }}</td>
              <td class="px-5 py-3 text-gray-700 dark:text-gray-300">{{ $customer->user->email }}</td>
              <td class="px-5 py-3 text-gray-700 dark:text-gray-300">{{ $customer->phone ?? '-' }}</td>
              <td class="px-5 py-3 text-right">
                <a href="{{ route('customers.edit', $customer) }}" onclick="event.stopPropagation()" class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-400 font-medium">Edit</a>
                <button 
                  @click.prevent="
                    event.stopPropagation();
                    title = '{{ $customer->name }}';
                    deleteUrl = '{{ route('customers.destroy', $customer) }}';
                    isModalOpen = true
                  "
                  class="text-red-600 hover:text-red-700 dark:hover:text-red-400 ml-3 font-medium">
                  Delete
                </button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-5 py-6 text-center text-gray-500 dark:text-gray-400">No customers found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="p-4">{{ $customers->appends(request()->query())->links() }}</div>
  </div>

  <x-modal.modal-delete />
</div>
@endsection