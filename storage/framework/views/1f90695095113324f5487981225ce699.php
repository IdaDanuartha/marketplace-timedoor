<?php $__env->startSection('title','Forgot Password'); ?>
<?php $__env->startSection('content'); ?>
<div class="flex flex-col items-center justify-center h-screen px-6 text-center dark:bg-gray-900">
  <h1 class="text-xl font-semibold">Reset Password</h1>

  <?php if($errors->any()): ?>
    <div class="p-3 rounded bg-red-50 text-red-600"><?php echo e($errors->first()); ?></div>
  <?php endif; ?>

  <form action="<?php echo e(route('password.update')); ?>" method="POST" class="space-y-4">
    <?php echo csrf_field(); ?>
    <input type="hidden" name="token" value="<?php echo e($token); ?>">
    <input type="hidden" name="email" value="<?php echo e(request('email', $email ?? '')); ?>">

    <label class="block text-sm font-medium">New Password</label>
    <input type="password" name="password" class="w-full border rounded px-3 py-2" required>

    <label class="block text-sm font-medium">Confirm Password</label>
    <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2" required>

    <button class="px-4 py-2 bg-blue-600 text-white rounded">Change Password</button>
  </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/auth/passwords/reset.blade.php ENDPATH**/ ?>