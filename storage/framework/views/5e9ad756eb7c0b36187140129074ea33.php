<?php $__env->startSection('title', 'Payment'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto py-8 text-center">
  <h1 class="text-xl font-bold text-gray-800 dark:text-white mb-3">Payment for Order <?php echo e($order->code); ?></h1>
  <p class="text-gray-500 dark:text-gray-400 mb-6">Complete your payment securely using Midtrans</p>

  <button id="pay-button" class="px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700">
    Pay Now
  </button>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo e(config('midtrans.client_key')); ?>"></script>
<script type="text/javascript">
document.getElementById('pay-button').addEventListener('click', function () {
    window.snap.pay('<?php echo e($snapToken); ?>', {
        onSuccess: function(result){
            window.location.href = "<?php echo e(route('shop.checkout.success', $order)); ?>";
        },
        onPending: function(result){ console.log('Waiting for payment confirmation.'); },
        onError: function(result){ console.log('Payment failed. Please try again.'); },
        onClose: function(){ console.log('Payment popup closed without finishing.'); }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/shop/checkout/payment.blade.php ENDPATH**/ ?>