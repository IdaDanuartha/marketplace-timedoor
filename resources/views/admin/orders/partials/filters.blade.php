<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3 mb-6">
    <form method="GET" class="flex flex-wrap items-center gap-2 w-full lg:w-auto">
      <input type="text" 
        name="search" 
        value="{{ $filters['search'] ?? '' }}" 
        placeholder="Search order or customer..." 
        class="border border-gray-300 rounded-lg px-3 py-2 w-full sm:w-64 bg-white dark:bg-transparent dark:border-white/20 dark:text-white text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
      >

      <select name="status" class="select2 rounded-lg border border-gray-300 px-3 py-2 w-[150px]">
        <option value="">All Status</option>
        @foreach ($statuses as $status)
          <option value="{{ $status->value }}" @selected(($filters['status'] ?? '') === $status->value)>
            {{ $status->label() }}
          </option>
        @endforeach
      </select>

      <select name="payment_status" class="select2 rounded-lg border border-gray-300 px-3 py-2 w-[150px]">
        <option value="">All Payment</option>
        @foreach(['unpaid', 'paid', 'failed'] as $ps)
          <option value="{{ $ps }}" @selected(($filters['payment_status'] ?? '') === $ps)>
            {{ ucfirst($ps) }}
          </option>
        @endforeach
      </select>

      <select name="payment_method" class="select2 rounded-lg border border-gray-300 px-3 py-2 w-[160px]">
        <option value="">All Methods</option>
        @foreach(['bank_transfer', 'gopay', 'qris', 'credit_card'] as $method)
          <option value="{{ $method }}" @selected(($filters['payment_method'] ?? '') === $method)>
            {{ ucwords(str_replace('_', ' ', $method)) }}
          </option>
        @endforeach
      </select>

      <div class="flex gap-3">
        <input type="date" 
          name="date_from" 
          value="{{ $filters['date_from'] ?? '' }}" 
          class="border border-gray-300 rounded-lg px-3 py-2 w-40"
        >
        <input type="date" 
          name="date_to" 
          value="{{ $filters['date_to'] ?? '' }}" 
          class="border border-gray-300 rounded-lg px-3 py-2 w-40"
        >
      </div>

      <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition whitespace-nowrap">
        Filter
      </button>
    </form>
  </div>