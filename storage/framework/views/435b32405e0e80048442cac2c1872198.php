<?php $__env->startSection('title', 'Category Details'); ?>

<?php $__env->startSection('content'); ?>
<nav class="mb-6 text-sm text-gray-500">
  <ol class="flex items-center space-x-2">
    <li><a href="<?php echo e(route('dashboard.index')); ?>" class="hover:underline">Dashboard</a></li>
    <li>/</li>
    <li><a href="<?php echo e(route('categories.index')); ?>" class="hover:underline">Categories</a></li>
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
          <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Category Details</h3>
        </div>

        
        <div class="p-6 space-y-8">
          
          <div>
            <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-2"><?php echo e($category->name); ?></h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Slug: <span class="font-mono"><?php echo e($category->slug); ?></span></p>

            <?php if($category->parent): ?>
              <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Parent Category: <span class="font-medium text-gray-800 dark:text-gray-200"><?php echo e($category->parent->name); ?></span>
              </p>
            <?php endif; ?>
          </div>

          
          <div class="rounded-xl border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900/40 p-5">
            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4">Products in this Category</h4>
            <?php if($products->count()): ?>
              <div class="overflow-x-auto">
                <table class="min-w-full text-sm border border-gray-100 dark:border-gray-800 rounded-lg">
                  <thead class="bg-gray-100 dark:bg-gray-800/30 text-gray-700 dark:text-gray-300">
                    <tr>
                      <th class="px-4 py-2 text-left">Product</th>
                      <th class="px-4 py-2 text-left">Vendor</th>
                      <th class="px-4 py-2 text-center">Price</th>
                      <th class="px-4 py-2 text-center">Status</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php
                        $color = match($product->status) {
                          \App\Enum\ProductStatus::ACTIVE => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
                          \App\Enum\ProductStatus::DRAFT => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300',
                          \App\Enum\ProductStatus::OUT_OF_STOCK => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300',
                        };
                      ?>
                      <tr 
                        class="hover:bg-gray-50 dark:hover:bg-gray-800/40 cursor-pointer"
                        onclick="window.location='<?php echo e(route('products.show', $product)); ?>'"
                      >
                        <td class="px-4 py-2 font-medium text-gray-800 dark:text-gray-200"><?php echo e($product->name); ?></td>
                        <td class="px-4 py-2 text-gray-600 dark:text-gray-400"><?php echo e($product->vendor->name ?? '-'); ?></td>
                        <td class="px-4 py-2 text-center text-gray-700 dark:text-gray-300">Rp<?php echo e(number_format($product->price, 0, ',', '.')); ?></td>
                        <td class="px-4 py-2 text-center">
                          <span class="px-2 py-1 rounded-full text-xs font-medium <?php echo e($color); ?>">
                            <?php echo e($product->status->label()); ?>

                          </span>
                        </td>
                      </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
                </table>
              </div>

              <div class="pt-4">
                <?php echo e($products->links()); ?>

              </div>
            <?php else: ?>
              <p class="text-sm text-gray-500 dark:text-gray-400">No products in this category yet.</p>
            <?php endif; ?>
          </div>

          
          <div class="flex flex-wrap justify-between items-center pt-6 border-t border-gray-100 dark:border-gray-800">
            <a href="<?php echo e(route('categories.index')); ?>" 
               class="text-sm text-gray-500 hover:underline">← Back to Categories</a>

            <div class="flex items-center gap-3">
              <a href="<?php echo e(route('categories.edit', $category)); ?>" 
                 class="px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                Edit
              </a>
              <button 
                @click.prevent="
                  title = '<?php echo e($category->name); ?>';
                  deleteUrl = '<?php echo e(route('categories.destroy', $category)); ?>';
                  isModalOpen = true;
                "
                class="px-4 py-2 bg-red-600 text-white text-sm rounded-lg hover:bg-red-700 transition">
                Delete
              </button>
            </div>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/admin/categories/show.blade.php ENDPATH**/ ?>