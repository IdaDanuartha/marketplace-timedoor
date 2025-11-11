<tr class="hover:bg-gray-50 dark:hover:bg-gray-800/40 cursor-pointer" onclick="window.location='<?php echo e(route('categories.show', $category)); ?>'">
  <td class="px-5 py-3">
    <span class="font-semibold text-gray-800 dark:text-white"><?php echo e($category->name); ?></span>
  </td>

  <td class="px-5 py-3 text-gray-700 dark:text-gray-300">
    <?php echo e($category->parent?->name ?? '-'); ?>

  </td>

  <td class="px-5 py-3 text-gray-700 dark:text-gray-300">
    <?php echo e(count($category->products)); ?> <?php echo e(Str::plural('product', count($category->products))); ?>

  </td>

  <td class="px-5 py-3 text-right">
    <a href="<?php echo e(route('categories.edit', $category)); ?>" onclick="event.stopPropagation()"
       class="text-blue-600 hover:text-blue-800 dark:hover:text-blue-400 font-medium transition">
      Edit
    </a>
    <button 
      @click.prevent="
        event.stopPropagation();
        title = '<?php echo e($category->name); ?>'; 
        deleteUrl = '<?php echo e(route('categories.destroy', $category)); ?>'; 
        isModalOpen = true
      "
      class="text-red-600 hover:text-red-700 dark:hover:text-red-400 ml-3 font-medium transition"
    >
      Delete
    </button>
  </td>
</tr><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/admin/categories/partials/category-row.blade.php ENDPATH**/ ?>