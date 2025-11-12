<?php $__env->startSection('title', 'Edit Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto space-y-8">
  <h1 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">Edit Profile</h1>

  
  <?php if(session('success')): ?>
    <div class="p-3 rounded-lg bg-green-100 text-green-700 border border-green-200">
      <?php echo e(session('success')); ?>

    </div>
  <?php endif; ?>
  <?php if($errors->any()): ?>
    <div class="p-3 rounded-lg bg-red-100 text-red-700 border border-red-200">
      <ul class="list-disc list-inside">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
  <?php endif; ?>

  
  <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    
    <div class="grid md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">Username</label>
        <input type="text" name="username" value="<?php echo e(old('username', $user->username)); ?>"
          class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Email</label>
        <input type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>"
          class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
      </div>
    </div>

    
    <div class="grid md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium mb-1">New Password</label>
        <input type="password" name="password"
          class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white"
          placeholder="Leave blank to keep current password">
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Confirm Password</label>
        <input type="password" name="password_confirmation"
          class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white"
          placeholder="Confirm new password">
      </div>
    </div>

    
    <div>
      <label class="block text-sm font-medium mb-2">Profile Image</label>
      <div id="dropzone" 
           class="dropzone rounded-xl border border-dashed border-gray-300 bg-gray-50 p-7 lg:p-10
                  dark:border-gray-700 dark:bg-gray-900 cursor-pointer text-center">
        <input type="file" name="profile_image" id="fileInput" class="hidden" accept="image/*">
        <div id="preview" class="<?php echo e($user->profile_image ? '' : 'hidden'); ?> mb-4 flex justify-center">
          <img id="previewImage"
               src="<?php echo e($user->profile_image ? profile_image($user->profile_image) : ''); ?>"
               class="max-h-48 rounded-lg border dark:border-gray-700">
        </div>
        <div id="dz-message" onclick="document.getElementById('fileInput').click()">
          <h4 class="text-lg font-semibold text-gray-800 dark:text-white/90">Drop or Browse</h4>
          <p class="text-sm text-gray-500">Upload PNG, JPG, WEBP, or SVG image</p>
        </div>
      </div>
      <?php if($user->profile_image): ?>
        <a href="<?php echo e(profile_image($user->profile_image)); ?>" target="_blank"
          class="text-xs text-blue-500 hover:underline block mt-2">View Current Image</a>
      <?php endif; ?>
      <?php $__errorArgs = ['profile_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <p class="mt-1 text-xs text-red-600 dark:text-red-400"><?php echo e($message); ?></p>
      <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    
    <?php if($user->admin): ?>
      <div>
        <label class="block text-sm font-medium mb-1">Name</label>
        <input type="text" name="name" value="<?php echo e(old('name', $user->admin->name)); ?>"
          class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
      </div>
    <?php elseif($user->vendor): ?>
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium mb-1">Vendor Name</label>
          <input type="text" name="name" value="<?php echo e(old('name', $user->vendor->name)); ?>"
            class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Address</label>
          <textarea name="address" rows="3"
            class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white"><?php echo e(old('address', $user->vendor->address)); ?></textarea>
        </div>
      </div>
    <?php elseif($user->customer): ?>
      <div class="space-y-4">
        <div>
          <label class="block text-sm font-medium mb-1">Customer Name</label>
          <input type="text" name="name" value="<?php echo e(old('name', $user->customer->name)); ?>"
            class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Phone</label>
          <input type="text" name="phone" value="<?php echo e(old('phone', $user->customer->phone)); ?>"
            class="w-full border rounded-lg px-3 py-2 dark:bg-gray-900 dark:border-gray-700 dark:text-white">
        </div>
      </div>
    <?php endif; ?>

    <div class="text-right">
      <button type="submit"
        class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium">
        Save Changes
      </button>
    </div>
  </form>

  
  <div x-data="{ open: false }" class="pt-10 border-t border-gray-200 dark:border-gray-800">
    <h2 class="text-lg font-semibold text-red-600 dark:text-red-400 mb-3">Danger Zone</h2>
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
      Once you delete your account, all of your data will be permanently removed. 
      This action cannot be undone. You will receive an email to confirm this action.
    </p>

    <button 
      @click="open = true"
      class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-medium transition">
      Request Account Deletion
    </button>

    <!-- Modal -->
    <div 
      x-show="open"
      x-transition.opacity
      x-cloak
      class="fixed inset-0 flex items-center justify-center p-5 z-99999"
    >
      <div @click="open = false" class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>
      <div 
        @click.outside="open = false"
        x-transition.scale.origin.bottom
        class="relative w-full max-w-md rounded-2xl bg-white dark:bg-gray-900 shadow-lg p-6"
      >
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Confirm Account Deletion</h2>
          <button @click="open = false" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">✕</button>
        </div>

        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
          Enter your password to confirm. A confirmation link will be sent to your email.
        </p>

        <form action="<?php echo e(route('account.deletion.request')); ?>" method="POST" class="space-y-4">
          <?php echo csrf_field(); ?>
          <div>
            <label class="block text-sm font-medium mb-1 text-gray-700 dark:text-gray-300">Password</label>
            <input type="password" name="password" required
              class="w-full border rounded-lg px-3 py-2 dark:bg-gray-800 dark:border-gray-700 dark:text-white text-sm"
              placeholder="Enter your password">
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
              <p class="text-xs text-red-600 mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>

          <div class="flex justify-end gap-3 pt-3">
            <button 
              type="button"
              @click="open = false"
              class="px-4 py-2 border border-gray-300 dark:border-gray-700 text-sm rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 transition">
              Cancel
            </button>
            <button 
              type="submit"
              class="px-4 py-2 bg-red-600 hover:bg-red-700 text-sm rounded-lg text-white transition">
              Confirm Deletion
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
document.addEventListener('DOMContentLoaded', () => {
  const input = document.getElementById('fileInput');
  const previewContainer = document.getElementById('preview');
  const previewImage = document.getElementById('previewImage');
  const dropzone = document.getElementById('dropzone');

  dropzone.addEventListener('click', () => input.click());
  dropzone.addEventListener('dragover', e => {
    e.preventDefault();
    dropzone.classList.add('bg-blue-50', 'dark:bg-blue-900/20');
  });
  dropzone.addEventListener('dragleave', () => {
    dropzone.classList.remove('bg-blue-50', 'dark:bg-blue-900/20');
  });
  dropzone.addEventListener('drop', e => {
    e.preventDefault();
    input.files = e.dataTransfer.files;
    input.dispatchEvent(new Event('change'));
    dropzone.classList.remove('bg-blue-50', 'dark:bg-blue-900/20');
  });

  input.addEventListener('change', e => {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
      previewImage.src = e.target.result;
      previewContainer.classList.remove('hidden');
    };
    reader.readAsDataURL(file);
  });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/profile/edit.blade.php ENDPATH**/ ?>