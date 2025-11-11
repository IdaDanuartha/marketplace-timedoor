<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>
      <?php echo $__env->yieldContent('title', 'Dashboard'); ?> | <?php echo e(config('app.name')); ?>

    </title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <?php echo $__env->yieldPushContent('css'); ?>

    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/<?php echo e(config('app.tinymce_api_key')); ?>/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
      /* Match Select2 to Tailwind input style */
      .select2-container .select2-selection--single {
        height: 42px !important;
        border: 1px solid #d1d5db !important; /* gray-300 */
        border-radius: 0.5rem !important; /* rounded-lg */
        display: flex !important;
        align-items: center !important;
        background-color: white !important;
      }

      .dark .select2-container .select2-selection--single {
        background-color: #111827 !important; /* dark:bg-gray-900 */
        border-color: #374151 !important; /* dark:border-gray-700 */
        color: #e5e7eb !important; /* dark:text-gray-200 */
      }

      .select2-container--default .select2-selection__rendered {
        color: inherit !important;
        font-size: 0.875rem !important;
        padding-left: 10px !important;
      }

      .select2-container--default .select2-selection__arrow {
        height: 38px !important;
        right: 10px !important;
      }

      .dark .select2-dropdown {
        background-color: #1f2937 !important;
        color: #e5e7eb !important;
      }
    </style>
  </head>
  <body
    x-data="{ page: 'ecommerce', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
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
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
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
    <div class="flex h-screen overflow-hidden">
      <!-- ===== Sidebar Start ===== -->
      <?php if (isset($component)) { $__componentOriginald31f0a1d6e85408eecaaa9471b609820 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald31f0a1d6e85408eecaaa9471b609820 = $attributes; } ?>
<?php $component = App\View\Components\Sidebar::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Sidebar::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald31f0a1d6e85408eecaaa9471b609820)): ?>
<?php $attributes = $__attributesOriginald31f0a1d6e85408eecaaa9471b609820; ?>
<?php unset($__attributesOriginald31f0a1d6e85408eecaaa9471b609820); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald31f0a1d6e85408eecaaa9471b609820)): ?>
<?php $component = $__componentOriginald31f0a1d6e85408eecaaa9471b609820; ?>
<?php unset($__componentOriginald31f0a1d6e85408eecaaa9471b609820); ?>
<?php endif; ?>
      <!-- ===== Sidebar End ===== -->

      <!-- ===== Content Area Start ===== -->
      <div
        class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto"
      >
        <!-- Small Device Overlay Start -->
        <?php if (isset($component)) { $__componentOriginal0f9a2e34269d28aaa76a6394688ce54c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0f9a2e34269d28aaa76a6394688ce54c = $attributes; } ?>
<?php $component = App\View\Components\Overlay::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('overlay'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Overlay::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0f9a2e34269d28aaa76a6394688ce54c)): ?>
<?php $attributes = $__attributesOriginal0f9a2e34269d28aaa76a6394688ce54c; ?>
<?php unset($__attributesOriginal0f9a2e34269d28aaa76a6394688ce54c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0f9a2e34269d28aaa76a6394688ce54c)): ?>
<?php $component = $__componentOriginal0f9a2e34269d28aaa76a6394688ce54c; ?>
<?php unset($__componentOriginal0f9a2e34269d28aaa76a6394688ce54c); ?>
<?php endif; ?>
        <!-- Small Device Overlay End -->

        <!-- ===== Header Start ===== -->
        <?php if (isset($component)) { $__componentOriginal2a2e454b2e62574a80c8110e5f128b60 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2a2e454b2e62574a80c8110e5f128b60 = $attributes; } ?>
<?php $component = App\View\Components\Header::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Header::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2a2e454b2e62574a80c8110e5f128b60)): ?>
<?php $attributes = $__attributesOriginal2a2e454b2e62574a80c8110e5f128b60; ?>
<?php unset($__attributesOriginal2a2e454b2e62574a80c8110e5f128b60); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2a2e454b2e62574a80c8110e5f128b60)): ?>
<?php $component = $__componentOriginal2a2e454b2e62574a80c8110e5f128b60; ?>
<?php unset($__componentOriginal2a2e454b2e62574a80c8110e5f128b60); ?>
<?php endif; ?>
        <!-- ===== Header End ===== -->

        <!-- ===== Main Content Start ===== -->
        <main>
          <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
            <?php echo $__env->yieldContent('content'); ?>
          </div>
        </main>
        <!-- ===== Main Content End ===== -->
      </div>
      <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->

    <?php echo $__env->yieldPushContent('js'); ?>
  </body>
</html><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/layouts/app.blade.php ENDPATH**/ ?>