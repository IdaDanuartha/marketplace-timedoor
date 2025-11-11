<?php $__env->startSection('title', 'Edit Product'); ?>

<?php $__env->startSection('content'); ?>
<div class="grid grid-cols-12 gap-4 md:gap-6">
  <div class="col-span-12">
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
              <input type="text" name="name" value="<?php echo e(old('name', $product->name)); ?>" placeholder="Enter product name"
                class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white" required>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Price</label>
              <input type="number" name="price" value="<?php echo e(old('price', $product->price)); ?>" placeholder="Enter product price"
                class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white" required>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Stock</label>
              <input type="number" name="stock" value="<?php echo e(old('stock', $product->stock)); ?>" placeholder="Enter product stock"
                class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white" required>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Category</label>
              <select name="category_id" class="select2 w-full" required>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($category->id); ?>" <?php echo e($product->category_id == $category->id ? 'selected' : ''); ?>>
                    <?php echo e($category->name); ?>

                  </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Vendor</label>
              <select name="vendor_id" class="select2 w-full" required>
                <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($vendor->id); ?>" <?php echo e($product->vendor_id == $vendor->id ? 'selected' : ''); ?>>
                    <?php echo e($vendor->name); ?>

                  </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>

            <div>
              <label class="block text-sm font-medium mb-1">Status</label>
              <select name="status" class="select2 w-full" required>
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
          </div>

          
          <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3">
            <div class="px-5 py-4 sm:px-6 sm:py-5">
              <h3 class="text-base font-medium text-gray-800 dark:text-white/90">Product Image</h3>
            </div>

            <div class="space-y-6 border-t border-gray-100 p-5 sm:p-6 dark:border-gray-800">
              <?php if($product->image_path): ?>
                <div class="mb-4 text-center">
                  <img src="<?php echo e(profile_image($product->image_path ?? null)); ?>"
                       alt="Current Image"
                       class="max-h-48 mx-auto rounded-lg border">
                  <p class="text-sm text-gray-500 mt-2">Current Image</p>
                </div>
              <?php endif; ?>

              <div class="dropzone rounded-xl border border-dashed border-gray-300 bg-gray-50 p-7 lg:p-10 dark:border-gray-700 dark:bg-gray-900"
                   id="product-dropzone">
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

          
          <div class="pt-4">
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


<script>
  // File Preview
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

  // Initialize Select2
  document.addEventListener('DOMContentLoaded', () => {
    $('.select2').select2({
      width: '100%',
      minimumResultsForSearch: 0,
      dropdownCssClass: 'text-sm'
    });
  });

  // Initialize TinyMCE
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/admin/products/edit.blade.php ENDPATH**/ ?>