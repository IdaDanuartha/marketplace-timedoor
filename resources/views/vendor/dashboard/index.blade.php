@extends('layouts.app')

@section('title', 'Vendor Dashboard')

@section('content')
<div class="grid grid-cols-12 gap-4 md:gap-6">
  <div class="col-span-12 space-y-6">
    <!-- Metric Group -->
    <x-metric-group-dashboard :metrics="$metrics" />

    <!-- Charts Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <x-chart.monthly-sales-chart />
      <x-chart.top-selling-chart />
      <x-chart.top-products-chart />
    </div>
  </div>

  <!-- Recent Orders Table -->
  <div class="col-span-12">
    <x-table.recent-orders-table :recentOrders="$recentOrders" />
  </div>
</div>
@endsection

@push('js')
<script>
  window.chartData = @json($chartData);
  window.topProducts = @json($topProducts);
</script>
<script type="module" src="{{ mix('js/charts/dashboard.js') }}"></script>
@endpush