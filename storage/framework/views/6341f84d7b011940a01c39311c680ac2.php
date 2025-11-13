<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php
    $isSelected = old('category_id', $selectedCategory ?? null) == $category->id;
  ?>
  <option value="<?php echo e($category->id); ?>" <?php echo e($isSelected ? 'selected' : ''); ?>>
    <?php echo e(str_repeat('— ', $depth) . $category->name); ?>

  </option>

  <?php if($category->children && $category->children->isNotEmpty()): ?>
    <?php echo $__env->make('admin.products.partials.category-options', [
      'categories' => $category->children,
      'depth' => $depth + 1,
      'selectedCategory' => $selectedCategory ?? null,
    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
  <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/admin/products/partials/category-options.blade.php ENDPATH**/ ?>