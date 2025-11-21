<div 
    x-show="isConfirmModalOpen"
    x-cloak
    class="fixed inset-0 flex items-center justify-center p-5 z-99999"
>

    <!-- Backdrop -->
    <div @click="isConfirmModalOpen = false"
        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm">
    </div>

    <!-- Modal -->
    <div @click.outside="isConfirmModalOpen = false"
        class="relative w-full max-w-md rounded-2xl bg-white dark:bg-gray-900 shadow-lg p-6">

        
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100" 
                x-text="confirmTitle">
            </h2>

            <button @click="isConfirmModalOpen = false"
                class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                ✕
            </button>
        </div>

        
        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6" 
           x-html="confirmMessage">
        </p>

        
        <div class="flex justify-end gap-3">
            <button @click="isConfirmModalOpen = false"
                class="px-4 py-2 border border-gray-300 dark:border-gray-700 text-sm rounded-lg 
                       hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-700 dark:text-gray-300 transition">
                <?php echo e($cancelText ?? 'Cancel'); ?>

            </button>

            <button @click="confirmAction"
                class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-sm rounded-lg text-white transition">
                <?php echo e($confirmText ?? 'Confirm'); ?>

            </button>
        </div>

    </div>
</div><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/components/modal/send-invoice-modal.blade.php ENDPATH**/ ?>