@extends('layouts.app')

@section('title')
    Admin Dashboard
@endsection
@section('content')
    <div class="grid grid-cols-12 gap-4 md:gap-6">
        <div class="col-span-12 space-y-6">
        <!-- Metric Group One -->
        <x-metric-group-dashboard :metrics="$metrics" />
        <!-- Metric Group One -->
        
        <!-- ====== Chart One Start -->
        <x-chart.monthly-sales-chart />
        <!-- ====== Chart One End -->
        </div>
        <div class="col-span-12">
        <!-- ====== Table One Start -->
        <x-table.recent-orders-table :recentOrders="$recentOrders" />
        <!-- ====== Table One End -->
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