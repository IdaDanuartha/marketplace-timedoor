<?php $__env->startSection('title', 'Web Settings'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto space-y-8">
  <div class="flex items-center justify-between">
    <h1 class="text-xl font-semibold text-gray-800 dark:text-white">Website Settings</h1>
  </div>

  <?php if(session('success')): ?>
    <div class="p-3 rounded-lg bg-green-100 text-green-700 border border-green-200">
      <?php echo e(session('success')); ?>

    </div>
  <?php endif; ?>

  <form action="<?php echo e(route('settings.update')); ?>" method="POST" enctype="multipart/form-data" class="space-y-10">
    <?php echo csrf_field(); ?>

    <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
          <h2 class="font-semibold text-lg capitalize text-gray-800 dark:text-white"><?php echo e($group); ?> Settings</h2>
          <span class="text-xs text-gray-400 uppercase tracking-wider"><?php echo e(count($items)); ?> items</span>
        </div>

        <div class="grid md:grid-cols-2 gap-6 p-6">
          <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div>
                <label class="block text-sm font-medium mb-2 capitalize text-gray-700 dark:text-gray-300">
                <?php echo e(str_replace('_', ' ', $item['key'])); ?>

                </label>

                
                <?php if($item['type'] === 'boolean'): ?>
                <div class="flex items-center space-x-3">
                    <input type="hidden" name="<?php echo e($item['key']); ?>" value="0">
                    <label class="relative inline-flex cursor-pointer items-center">
                    <input type="checkbox" name="<?php echo e($item['key']); ?>" value="1"
                        <?php echo e(old($item['key'], $item['value']) ? 'checked' : ''); ?>

                        class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer dark:bg-gray-700
                                peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600 transition-colors duration-200"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white border rounded-full
                                transition-transform duration-200 peer-checked:translate-x-full peer-checked:border-blue-600"></div>
                    </label>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Enable</span>
                </div>

                <?php $__errorArgs = [$item['key']];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                
                <?php elseif($item['type'] === 'file'): ?>
                <div x-data="{ filePreview: '<?php echo e($item['value']); ?>' }">
                    <div id="dropzone-<?php echo e($item['key']); ?>"
                        class="dropzone rounded-xl border border-dashed border-gray-300 bg-gray-50 p-7 lg:p-8
                                dark:border-gray-700 dark:bg-gray-800 cursor-pointer text-center relative overflow-hidden">
                    <input type="file" name="<?php echo e($item['key']); ?>" accept="image/*"
                            @change="const f=$event.target.files[0];
                                    if(f){ const r=new FileReader();
                                    r.onload=e=>filePreview=e.target.result; r.readAsDataURL(f);}">

                    <template x-if="filePreview">
                        <div class="mb-3 flex justify-center">
                        <img :src="filePreview" class="max-h-32 rounded-lg border border-gray-200 dark:border-gray-700">
                        </div>
                    </template>

                    <div class="text-sm text-gray-600 dark:text-gray-400">Drop or Browse</div>
                    <p class="text-xs text-gray-400 mt-1">Upload PNG, JPG, WEBP, or SVG</p>
                    </div>

                    <?php if($item['value']): ?>
                    <a href="<?php echo e($item['value']); ?>" target="_blank" class="text-xs text-blue-500 hover:underline block mt-2">Current file</a>
                    <?php endif; ?>
                </div>

                <?php $__errorArgs = [$item['key']];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                
                <?php elseif($item['type'] === 'json'): ?>
                <textarea name="<?php echo e($item['key']); ?>" rows="3"
                    class="w-full border rounded-lg px-3 py-2 dark:bg-gray-800 dark:border-gray-700 dark:text-white text-sm
                        <?php $__errorArgs = [$item['key']];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 dark:border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    placeholder="Enter JSON data"><?php echo e(old($item['key'], json_encode(json_decode($item['value'] ?? '[]'), JSON_PRETTY_PRINT))); ?></textarea>

                <?php $__errorArgs = [$item['key']];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                
                <?php elseif(Str::contains($item['key'], ['description', 'address', 'meta'])): ?>
                <textarea name="<?php echo e($item['key']); ?>" rows="3"
                    class="w-full border rounded-lg px-3 py-2 dark:bg-gray-800 dark:border-gray-700 dark:text-white text-sm
                        <?php $__errorArgs = [$item['key']];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 dark:border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    placeholder="Enter <?php echo e(str_replace('_', ' ', $item['key'])); ?>"><?php echo e(old($item['key'], $item['value'])); ?></textarea>

                <?php $__errorArgs = [$item['key']];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                
                <?php else: ?>
                <input type="text" name="<?php echo e($item['key']); ?>" value="<?php echo e(old($item['key'], $item['value'])); ?>"
                    class="w-full border rounded-lg px-3 py-2 dark:bg-gray-800 dark:border-gray-700 dark:text-white text-sm
                        <?php $__errorArgs = [$item['key']];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 dark:border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    placeholder="Enter <?php echo e(str_replace('_', ' ', $item['key'])); ?>">

                <?php $__errorArgs = [$item['key']];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <div class="text-right">
      <button type="submit"
        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
        Save Changes
      </button>
    </div>
  </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('js'); ?>
<script>
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.dropzone input[type="file"]').forEach(input => {
    const dropzone = input.closest('.dropzone');

    dropzone.addEventListener('click', () => input.click());
    dropzone.addEventListener('dragover', (e) => {
      e.preventDefault();
      dropzone.classList.add('bg-blue-50', 'dark:bg-blue-900/20');
    });
    dropzone.addEventListener('dragleave', () => {
      dropzone.classList.remove('bg-blue-50', 'dark:bg-blue-900/20');
    });
    dropzone.addEventListener('drop', (e) => {
      e.preventDefault();
      input.files = e.dataTransfer.files;
      input.dispatchEvent(new Event('change'));
      dropzone.classList.remove('bg-blue-50', 'dark:bg-blue-900/20');
    });
  });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/admin/settings/index.blade.php ENDPATH**/ ?>