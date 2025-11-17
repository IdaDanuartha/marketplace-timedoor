<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice <?php echo e($order->code); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: #1e3a8a;
            color: #fff;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px 20px;
        }
        .order-info {
            background: #f9fafb;
            border-left: 4px solid #1e3a8a;
            padding: 15px;
            margin: 20px 0;
        }
        .order-info p {
            margin: 5px 0;
        }
        .total {
            font-size: 20px;
            font-weight: bold;
            color: #1e3a8a;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: #1e3a8a;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .button:hover {
            background: #1e40af;
        }
        .footer {
            background: #f9fafb;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #e5e7eb;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table th,
        table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        table th {
            background: #f3f4f6;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><?php echo e(setting('site_name')); ?></h1>
            <p>Invoice #<?php echo e($order->code); ?></p>
        </div>

        <div class="content">
            <h2>Hello <?php echo e($order->customer->name ?? 'Customer'); ?>,</h2>
            <p>Thank you for your order! Please find your invoice details below.</p>

            <div class="order-info">
                <p><strong>Order Code:</strong> <?php echo e($order->code); ?></p>
                <p><strong>Order Date:</strong> <?php echo e($order->created_at->format('d M Y')); ?></p>
                <p><strong>Payment Method:</strong> <?php echo e(ucwords(str_replace('_', ' ', $order->payment_method ?? 'N/A'))); ?></p>
                <p><strong>Payment Status:</strong> <span style="text-transform: uppercase;"><?php echo e($order->payment_status); ?></span></p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($item->product->name ?? '-'); ?></td>
                        <td style="text-align: center;"><?php echo e($item->qty); ?></td>
                        <td style="text-align: right;">Rp<?php echo e(number_format($item->price * $item->qty, 0, ',', '.')); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td colspan="2" style="text-align: right;"><strong>Subtotal:</strong></td>
                        <td style="text-align: right;"><strong>Rp<?php echo e(number_format($order->total_price, 0, ',', '.')); ?></strong></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: right;"><strong>Shipping:</strong></td>
                        <td style="text-align: right;"><strong>Rp<?php echo e(number_format($order->shipping_cost, 0, ',', '.')); ?></strong></td>
                    </tr>
                    <tr style="background: #f9fafb;">
                        <td colspan="2" style="text-align: right;"><strong>Grand Total:</strong></td>
                        <td style="text-align: right;" class="total">Rp<?php echo e(number_format($order->grand_total, 0, ',', '.')); ?></td>
                    </tr>
                </tbody>
            </table>

            <div style="text-align: center;">
                <a href="<?php echo e($invoiceUrl); ?>" class="button">View Invoice Online</a>
            </div>

            <p style="margin-top: 30px; font-size: 14px; color: #666;">
                If you have any questions about this invoice, please contact our support team.
            </p>
        </div>

        <div class="footer">
            <p>&copy; <?php echo e(date('Y')); ?> <?php echo e(setting('site_name')); ?>. All rights reserved.</p>
            <p><?php echo e(setting('address') ?? ''); ?></p>
        </div>
    </div>
</body>
</html><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/emails/invoice.blade.php ENDPATH**/ ?>