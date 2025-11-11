<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title><?php echo $__env->yieldContent('title'); ?> | <?php echo e(config('app.name')); ?></title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
  </head>
  <body
    x-data="{ page: 'comingSoon', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900': darkMode === true}"
  >
    <!-- ===== Preloader Start ===== -->
    <?php if (isset($component)) { $__componentOriginal324afa24dd37aa61018b7e5bce28c60d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal324afa24dd37aa61018b7e5bce28c60d = $attributes; } ?>
<?php $component = App\View\Components\Preloader::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('preloader'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Preloader::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal324afa24dd37aa61018b7e5bce28c60d)): ?>
<?php $attributes = $__attributesOriginal324afa24dd37aa61018b7e5bce28c60d; ?>
<?php unset($__attributesOriginal324afa24dd37aa61018b7e5bce28c60d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal324afa24dd37aa61018b7e5bce28c60d)): ?>
<?php $component = $__componentOriginal324afa24dd37aa61018b7e5bce28c60d; ?>
<?php unset($__componentOriginal324afa24dd37aa61018b7e5bce28c60d); ?>
<?php endif; ?>
    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <?php echo $__env->yieldContent('content'); ?>
    <!-- ===== Page Wrapper End ===== -->
  </body>
</html><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/layouts/auth.blade.php ENDPATH**/ ?>