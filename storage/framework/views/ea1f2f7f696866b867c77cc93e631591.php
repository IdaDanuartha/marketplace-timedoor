<?php $__env->startSection('title', 'Vendor Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-12 gap-4 md:gap-6">
  <div class="col-span-12 space-y-6">
    <!-- Metric Group -->
    <?php if (isset($component)) { $__componentOriginal05a10049c130e9e1a2a316edd9f050e6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal05a10049c130e9e1a2a316edd9f050e6 = $attributes; } ?>
<?php $component = App\View\Components\MetricGroupDashboard::resolve(['metrics' => $metrics] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('metric-group-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\MetricGroupDashboard::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal05a10049c130e9e1a2a316edd9f050e6)): ?>
<?php $attributes = $__attributesOriginal05a10049c130e9e1a2a316edd9f050e6; ?>
<?php unset($__attributesOriginal05a10049c130e9e1a2a316edd9f050e6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal05a10049c130e9e1a2a316edd9f050e6)): ?>
<?php $component = $__componentOriginal05a10049c130e9e1a2a316edd9f050e6; ?>
<?php unset($__componentOriginal05a10049c130e9e1a2a316edd9f050e6); ?>
<?php endif; ?>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <?php if (isset($component)) { $__componentOriginaleb5fa027ae533bfeb7543073f99b25b8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaleb5fa027ae533bfeb7543073f99b25b8 = $attributes; } ?>
<?php $component = App\View\Components\Chart\MonthlySalesChart::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('chart.monthly-sales-chart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Chart\MonthlySalesChart::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaleb5fa027ae533bfeb7543073f99b25b8)): ?>
<?php $attributes = $__attributesOriginaleb5fa027ae533bfeb7543073f99b25b8; ?>
<?php unset($__attributesOriginaleb5fa027ae533bfeb7543073f99b25b8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaleb5fa027ae533bfeb7543073f99b25b8)): ?>
<?php $component = $__componentOriginaleb5fa027ae533bfeb7543073f99b25b8; ?>
<?php unset($__componentOriginaleb5fa027ae533bfeb7543073f99b25b8); ?>
<?php endif; ?>
      <?php if (isset($component)) { $__componentOriginal6cf8a7c8e2240e91d36b460990099071 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6cf8a7c8e2240e91d36b460990099071 = $attributes; } ?>
<?php $component = App\View\Components\Chart\TopSellingChart::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('chart.top-selling-chart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Chart\TopSellingChart::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6cf8a7c8e2240e91d36b460990099071)): ?>
<?php $attributes = $__attributesOriginal6cf8a7c8e2240e91d36b460990099071; ?>
<?php unset($__attributesOriginal6cf8a7c8e2240e91d36b460990099071); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6cf8a7c8e2240e91d36b460990099071)): ?>
<?php $component = $__componentOriginal6cf8a7c8e2240e91d36b460990099071; ?>
<?php unset($__componentOriginal6cf8a7c8e2240e91d36b460990099071); ?>
<?php endif; ?>
      <?php if (isset($component)) { $__componentOriginalfcda15cb64f1e66ef68960497b87d6b7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfcda15cb64f1e66ef68960497b87d6b7 = $attributes; } ?>
<?php $component = App\View\Components\Chart\TopProductsChart::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('chart.top-products-chart'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Chart\TopProductsChart::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfcda15cb64f1e66ef68960497b87d6b7)): ?>
<?php $attributes = $__attributesOriginalfcda15cb64f1e66ef68960497b87d6b7; ?>
<?php unset($__attributesOriginalfcda15cb64f1e66ef68960497b87d6b7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfcda15cb64f1e66ef68960497b87d6b7)): ?>
<?php $component = $__componentOriginalfcda15cb64f1e66ef68960497b87d6b7; ?>
<?php unset($__componentOriginalfcda15cb64f1e66ef68960497b87d6b7); ?>
<?php endif; ?>
    </div>
  </div>

  <!-- Recent Orders Table -->
  <div class="col-span-12">
    <?php if (isset($component)) { $__componentOriginal67fbdb781267f99df5676f65f4ed7825 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal67fbdb781267f99df5676f65f4ed7825 = $attributes; } ?>
<?php $component = App\View\Components\Table\RecentOrdersTable::resolve(['recentOrders' => $recentOrders] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('table.recent-orders-table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Table\RecentOrdersTable::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal67fbdb781267f99df5676f65f4ed7825)): ?>
<?php $attributes = $__attributesOriginal67fbdb781267f99df5676f65f4ed7825; ?>
<?php unset($__attributesOriginal67fbdb781267f99df5676f65f4ed7825); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal67fbdb781267f99df5676f65f4ed7825)): ?>
<?php $component = $__componentOriginal67fbdb781267f99df5676f65f4ed7825; ?>
<?php unset($__componentOriginal67fbdb781267f99df5676f65f4ed7825); ?>
<?php endif; ?>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<script>
  window.chartData = <?php echo json_encode($chartData, 15, 512) ?>;
  window.topProducts = <?php echo json_encode($topProducts, 15, 512) ?>;
</script>
<script type="module" src="<?php echo e(mix('js/charts/dashboard.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/vendor/dashboard/index.blade.php ENDPATH**/ ?>