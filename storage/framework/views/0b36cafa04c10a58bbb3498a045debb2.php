<?php $__env->startSection('title', 'Edit Product'); ?>

<?php $__env->startSection('content'); ?>
<?php
  $user = auth()->user();
  $isVendor = $user->vendor ? true : false;
?>

<div x-data="{ isModalOpen: false, title: '', deleteUrl: '' }" x-cloak class="grid grid-cols-12 gap-4 md:gap-6">
  <div class="col-span-12">
    
    <?php if($errors->any()): ?>
      <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700 dark:border-red-700/40 dark:bg-red-900/30 dark:text-red-300">
        <ul class="list-disc pl-5 space-y-1">
          <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
    <?php endif; ?>

    <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
      <div class="px-5 py-4 sm:px-6 sm:py-5 flex items-center justify-between">
        <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Edit Product</h3>
        <a href="<?php echo e(route('products.index')); ?>" class="text-sm text-blue-600 hover:underline">← Back</a>
      </div>

      <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
        <form action="<?php echo e(route('products.update', $product)); ?>" method="POST" enctype="multipart/form-data">
          <?php echo csrf_field(); ?>
          <?php echo method_field('PUT'); ?>

          
          <div class="grid grid-cols-2 gap-4">
            
            <div>
              <label class="block text-sm font-medium mb-1">Name</label>
              <input type="text" name="name" value="<?php echo e(old('name', $product->name)); ?>"
                placeholder="Enter product name"
                class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
              <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div>
              <label class="block text-sm font-medium mb-1">Price</label>
              <input type="number" name="price" value="<?php echo e(old('price', $product->price)); ?>"
                placeholder="Enter product price"
                class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
              <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div>
              <label class="block text-sm font-medium mb-1">Stock</label>
              <input type="number" name="stock" value="<?php echo e(old('stock', $product->stock)); ?>"
                placeholder="Enter product stock"
                class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
              <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div>
              <label class="block text-sm font-medium mb-1">Category</label>
              <select name="category_id" class="select2 w-full <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                <option value="">Select Category</option>
                <?php echo $__env->make('admin.products.partials.category-options', [
                  'categories' => $categories,
                  'depth' => 0,
                  'selectedCategory' => $product->category_id,
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
              </select>
              <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <?php if (! ($isVendor)): ?>
              <div>
                <label class="block text-sm font-medium mb-1">Vendor</label>
                <select name="vendor_id" class="select2 w-full <?php $__errorArgs = ['vendor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                  <option value="">Select Vendor</option>
                  <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($vendor->id); ?>" <?php echo e($product->vendor_id == $vendor->id ? 'selected' : ''); ?>>
                      <?php echo e($vendor->name); ?>

                    </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['vendor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                  <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              </div>
            <?php else: ?>
              <input type="hidden" name="vendor_id" value="<?php echo e($user->vendor->id); ?>">
            <?php endif; ?>

            
            <div>
              <label class="block text-sm font-medium mb-1">Status</label>
              <select name="status" class="select2 w-full <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                <?php $__currentLoopData = \App\Enum\ProductStatus::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($case->name); ?>"
                    <?php echo e(old('status', $product->status->name ?? \App\Enum\ProductStatus::ACTIVE->name) === $case->name ? 'selected' : ''); ?>>
                    <?php echo e($case->label()); ?>

                  </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
              <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
              <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
          </div>

          
          <div class="my-4">
            <label class="block text-sm font-medium mb-2">Description</label>
            <textarea name="description" id="editor" rows="6"><?php echo e(old('description', $product->description)); ?></textarea>
            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-sm text-red-500 mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          
          <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
            <div class="px-5 py-4 sm:px-6 sm:py-5">
              <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Product Image</h3>
            </div>

            <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
              <?php if($product->image_path): ?>
                <div class="mb-4 text-center">
                  <img src="<?php echo e(profile_image($product->image_path)); ?>"
                       alt="Current Image"
                       class="max-h-48 mx-auto rounded-lg border">
                  <p class="text-sm text-gray-500 mt-2">Current Image</p>
                </div>
              <?php endif; ?>

              <div id="product-dropzone"
                   class="dropzone rounded-xl border border-dashed border-gray-300 bg-gray-50 p-7 lg:p-10 dark:border-gray-700 dark:bg-gray-900">
                <input type="file" name="image_path" id="fileInput" class="hidden" accept="image/*">
                <div id="newPreview" class="flex justify-center mb-4 hidden">
                  <img id="previewImage" class="max-h-48 rounded-lg border" />
                </div>
                <div id="dz-message" class="dz-message text-center cursor-pointer"
                     onclick="document.getElementById('fileInput').click()">
                  <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90">Drop or Browse</h4>
                  <p class="text-sm text-gray-500">Drag your PNG, JPG, WebP, or SVG image here</p>
                </div>
              </div>
            </div>
          </div>

          
          <div class="pt-4 flex justify-between items-center">
            <div class="text-sm text-gray-500 dark:text-gray-400">
              <?php if($isVendor): ?>
                <span>This product belongs to your vendor account.</span>
              <?php endif; ?>
            </div>
            <button type="submit"
              class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm rounded-lg transition">
              Update Product
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<script>
  // === Image Preview ===
  const fileInput = document.getElementById('fileInput');
  const newPreview = document.getElementById('newPreview');
  const previewImage = document.getElementById('previewImage');

  fileInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = () => {
        previewImage.src = reader.result;
        newPreview.classList.remove('hidden');
      };
      reader.readAsDataURL(file);
    }
  });

  // === Select2 Init ===
  document.addEventListener('DOMContentLoaded', () => {
    $('.select2').select2({
      width: '100%',
      minimumResultsForSearch: 0,
      dropdownCssClass: 'text-sm'
    });
  });

  // === TinyMCE Init ===
  tinymce.init({
    selector: '#editor',
    height: 300,
    menubar: false,
    plugins: 'lists link image table code',
    toolbar: 'undo redo | bold italic underline | bullist numlist | link image',
    content_style: `
      body { font-family: Inter, sans-serif; font-size: 14px; }
      .dark & { color: #e5e7eb; background: #111827; }
    `
  });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/admin/products/edit.blade.php ENDPATH**/ ?>