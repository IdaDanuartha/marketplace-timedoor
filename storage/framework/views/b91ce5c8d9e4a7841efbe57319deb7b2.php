<?php $__env->startComponent('mail::message'); ?>
# Account Deletion Confirmation

Hello **<?php echo new \Illuminate\Support\EncodedHtmlString($username); ?>**,  

You recently requested to delete your account.  
Please confirm this action by clicking the button below:

<?php $__env->startComponent('mail::button', ['url' => $url]); ?>
Confirm Account Deletion
<?php echo $__env->renderComponent(); ?>

This link will expire in **30 minutes**.  
If you did not make this request, you can safely ignore this email.

---

Thanks,  
**The Timedoor Marketplace Team**

<?php echo $__env->renderComponent(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/emails/account-deletion-confirmation.blade.php ENDPATH**/ ?>