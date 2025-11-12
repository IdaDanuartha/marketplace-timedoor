<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vendor Approved</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>Hello, <?php echo e($vendorName); ?>!</h2>

    <p>
        Good news! 🎉 Your vendor account has been approved by the admin team.
    </p>

    <p>
        You can now log in and start managing your products and orders.
    </p>

    <p>
        <a href="<?php echo e(url('/dashboard')); ?>"
           style="background:#2563eb; color:white; padding:10px 16px;
                  text-decoration:none; border-radius:6px;">
            Go to Dashboard
        </a>
    </p>

    <br>
    <p>Best regards,<br><strong>The Admin Team</strong></p>
</body>
</html><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/emails/vendor-approved.blade.php ENDPATH**/ ?>