<?php $__env->startSection('title', 'Orders'); ?>

<?php $__env->startSection('content'); ?>
<div x-data="orderPage()" x-cloak>
    
    <!-- Breadcrumb -->
    <nav class="mb-6 text-sm text-gray-500">
        <ol class="flex items-center space-x-2">
            <li><a href="<?php echo e(route('dashboard.index')); ?>" class="hover:underline">Dashboard</a></li>
            <li>/</li>
            <li class="text-gray-700 dark:text-gray-300">Orders</li>
        </ol>
    </nav>

    <!-- Flash Messages -->
    <?php echo $__env->make('partials.flash-messages', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Filters -->
    <?php echo $__env->make('admin.orders.partials.filters', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Action Buttons -->
    <div class="flex justify-between items-center gap-4 mb-4">

        <!-- Button Send Invoice -->
        <button 
            x-show="selectedOrders.length > 0"
            @click="openSendInvoiceModal()"
            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition whitespace-nowrap flex items-center gap-2"
        >
            Send Invoices (<span x-text="selectedOrders.length"></span>)
        </button>

        <!-- Export / Create -->
        <div class="flex gap-4 ml-auto">
            <a href="<?php echo e(route('orders.export', request()->query())); ?>" 
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition whitespace-nowrap">
                Export Excel
            </a>

            <?php if(auth()->user()?->admin): ?>
                <a href="<?php echo e(route('orders.create')); ?>" 
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition whitespace-nowrap text-center">
                    + Add Order
                </a>
            <?php endif; ?>
        </div>

    </div>

    <!-- Table -->
    <?php echo $__env->make('admin.orders.partials.table', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <?php if (isset($component)) { $__componentOriginal4d1b5b59a854b83c5cb3506d26d92192 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4d1b5b59a854b83c5cb3506d26d92192 = $attributes; } ?>
<?php $component = App\View\Components\Modal\SendInvoiceModal::resolve(['confirmText' => 'Send Now','cancelText' => 'Back'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.send-invoice-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Modal\SendInvoiceModal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4d1b5b59a854b83c5cb3506d26d92192)): ?>
<?php $attributes = $__attributesOriginal4d1b5b59a854b83c5cb3506d26d92192; ?>
<?php unset($__attributesOriginal4d1b5b59a854b83c5cb3506d26d92192); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4d1b5b59a854b83c5cb3506d26d92192)): ?>
<?php $component = $__componentOriginal4d1b5b59a854b83c5cb3506d26d92192; ?>
<?php unset($__componentOriginal4d1b5b59a854b83c5cb3506d26d92192); ?>
<?php endif; ?>

    
    <?php if (isset($component)) { $__componentOriginalacfa148ccbbfb47f9db0a9452e7e721a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalacfa148ccbbfb47f9db0a9452e7e721a = $attributes; } ?>
<?php $component = App\View\Components\Modal\ModalDelete::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.modal-delete'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Modal\ModalDelete::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalacfa148ccbbfb47f9db0a9452e7e721a)): ?>
<?php $attributes = $__attributesOriginalacfa148ccbbfb47f9db0a9452e7e721a; ?>
<?php unset($__attributesOriginalacfa148ccbbfb47f9db0a9452e7e721a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalacfa148ccbbfb47f9db0a9452e7e721a)): ?>
<?php $component = $__componentOriginalacfa148ccbbfb47f9db0a9452e7e721a; ?>
<?php unset($__componentOriginalacfa148ccbbfb47f9db0a9452e7e721a); ?>
<?php endif; ?>

</div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('js'); ?>
<script>
function orderPage() {
    return {
        // Global confirm modal
        isConfirmModalOpen: false,
        confirmTitle: '',
        confirmMessage: '',
        confirmAction: null,

        // Selected orders
        selectedOrders: [],
        selectedCount: 0,
        selectAll: false,

        toggleAll() {
            const checkboxes = document.querySelectorAll('.order-checkbox');

            if (this.selectAll) {
                this.selectedOrders = Array.from(checkboxes).map(el => el.value);
            } else {
                this.selectedOrders = [];
            }
        },

        updateSelectAll() {
            const checkboxes = document.querySelectorAll('.order-checkbox');
            this.selectAll = checkboxes.length > 0 && this.selectedOrders.length === checkboxes.length;
        },

        // Send Invoice Modal
        openSendInvoiceModal() {
            this.selectedCount = this.selectedOrders.length;
            this.confirmTitle = "Send Invoices";
            this.confirmMessage = `
                You are about to send invoice emails for 
                <b>${this.selectedCount}</b> selected order(s).<br>This action cannot be undone.
            `;

            this.confirmAction = () => this.submitSendInvoices();
            this.isConfirmModalOpen = true;
        },

        submitSendInvoices() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = "<?php echo e(route('orders.send-invoices')); ?>";

            form.innerHTML = `
                <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
                ${this.selectedOrders.map(id =>
                    `<input type="hidden" name="order_ids[]" value="${id}">`
                ).join('')}
                <input type="hidden" name="send_pdf" value="1">
            `;

            document.body.appendChild(form);
            form.submit();
        },
    };
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    $('.select2').select2({
        width: 'resolve',
        minimumResultsForSearch: Infinity,
        dropdownAutoWidth: true,
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/admin/orders/index.blade.php ENDPATH**/ ?>