<?php $__env->startSection('title', 'Product Details'); ?>

<?php $__env->startSection('content'); ?>
<nav class="mb-6 text-sm text-gray-500">
  <ol class="flex items-center space-x-2">
    <li><a href="<?php echo e(route('dashboard.index')); ?>" class="hover:underline">Dashboard</a></li>
    <li>/</li>
    <li><a href="<?php echo e(route('products.index')); ?>" class="hover:underline">Products</a></li>
    <li>/</li>
    <li class="text-gray-700 dark:text-gray-300">Detail</li>
  </ol>
</nav>

<div 
  x-data="{ isModalOpen: false, title: '', deleteUrl: '' }"
  x-cloak
>
  <div class="grid grid-cols-12 gap-4 md:gap-6">
    <div class="col-span-12">
      <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">

        
        <div class="px-5 py-4 sm:px-6 sm:py-5 border-b border-gray-100 dark:border-gray-800">
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Product Details</h3>
        </div>

        
        <div class="p-6 space-y-8">
          
          <div class="flex flex-col md:flex-row items-start gap-6">
            
            <div class="w-40 h-40 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden bg-gray-50 dark:bg-gray-900 flex items-center justify-center">
              <?php if($product->image_path): ?>
                <img src="<?php echo e(profile_image($product->image_path ?? null)); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-full object-cover">
              <?php else: ?>
                <span class="text-gray-400 text-sm">No Image</span>
              <?php endif; ?>
            </div>

            
            <div class="flex-1">
              <h2 class="text-2xl font-semibold text-gray-800 dark:text-white"><?php echo e($product->name); ?></h2>

              <div class="mt-4 flex items-center gap-2">
                <?php
                  $color = match($product->status) {
                    \App\Enum\ProductStatus::ACTIVE => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
                    \App\Enum\ProductStatus::DRAFT => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
                    \App\Enum\ProductStatus::OUT_OF_STOCK => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
                  };
                ?>
                <span class="px-2 py-1 rounded-full text-xs font-medium <?php echo e($color); ?>">
                  <?php echo e($product->status->label()); ?>

                </span>
                <span class="text-gray-700 dark:text-gray-300 font-medium">
                  Rp<?php echo e(number_format($product->price, 0, ',', '.')); ?>

                </span>
              </div>

              <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                Stock: <span class="font-medium text-gray-800 dark:text-gray-200"><?php echo e($product->stock); ?></span>
              </p>
            </div>
          </div>

          
          <div class="grid sm:grid-cols-2 gap-6">
            
            <div class="rounded-xl border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/40 p-5">
              <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Category</h4>
              <?php if($product->category): ?>
                <p class="text-gray-800 dark:text-gray-200"><?php echo e($product->category->name); ?></p>
                <a href="<?php echo e(route('categories.show', $product->category)); ?>" 
                   class="text-blue-600 hover:underline text-sm">View Category →</a>
              <?php else: ?>
                <p class="text-gray-500 dark:text-gray-400 text-sm">No category assigned.</p>
              <?php endif; ?>
            </div>

            
            <div class="rounded-xl border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/40 p-5">
              <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Vendor</h4>
              <?php if($product->vendor): ?>
                <p class="text-gray-800 dark:text-gray-200"><?php echo e($product->vendor->name); ?></p>
                <?php if(auth()->user()?->admin): ?>
                  <a href="<?php echo e(route('vendors.show', $product->vendor)); ?>" 
                     class="text-blue-600 hover:underline text-sm">View Vendor →</a>
                    
                <?php endif; ?>
              <?php else: ?>
                <p class="text-gray-500 dark:text-gray-400 text-sm">No vendor assigned.</p>
              <?php endif; ?>
            </div>
          </div>

          
          <div class="rounded-xl border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/40 p-5">
            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Description</h4>
            <div class="prose dark:prose-invert max-w-none">
              <?php echo $product->description ?: '<p class="text-gray-500 dark:text-gray-400 text-sm">No description available.</p>'; ?>

            </div>
          </div>

          
          <div class="flex flex-wrap justify-between items-center pt-6 border-t border-gray-100 dark:border-gray-800">
            <a href="<?php echo e(route('products.index')); ?>" 
               class="text-sm text-gray-500 hover:underline">← Back to Products</a>

            <div class="flex items-center gap-3">
              <a href="<?php echo e(route('products.edit', $product)); ?>" 
                 class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                Edit
              </a>
              <button 
                @click.prevent="
                  title = '<?php echo e($product->name); ?>';
                  deleteUrl = '<?php echo e(route('products.destroy', $product)); ?>';
                  isModalOpen = true;
                "
                class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition">
                Delete
              </button>
            </div>
          </div>
        </div>

        
        <?php if (isset($component)) { $__componentOriginalacfa148ccbbfb47f9db0a9452e7e721a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalacfa148ccbbfb47f9db0a9452e7e721a = $attributes; } ?>
<?php $component = App\View\Components\Modal\ModalDelete::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.modal-delete'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Modal\ModalDelete::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalacfa148ccbbfb47f9db0a9452e7e721a)): ?>
<?php $attributes = $__attributesOriginalacfa148ccbbfb47f9db0a9452e7e721a; ?>
<?php unset($__attributesOriginalacfa148ccbbfb47f9db0a9452e7e721a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalacfa148ccbbfb47f9db0a9452e7e721a)): ?>
<?php $component = $__componentOriginalacfa148ccbbfb47f9db0a9452e7e721a; ?>
<?php unset($__componentOriginalacfa148ccbbfb47f9db0a9452e7e721a); ?>
<?php endif; ?>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/admin/products/show.blade.php ENDPATH**/ ?>