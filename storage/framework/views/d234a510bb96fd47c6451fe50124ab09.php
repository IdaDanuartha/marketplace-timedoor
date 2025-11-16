<?php
    $user = auth()->user();
    $role = $user->admin ? 'admin' : ($user->vendor ? 'vendor' : 'customer');

    $gridClass = match ($role) {
        'admin' => 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6',
        'vendor' => 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6',
        'customer' => 'grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6',
        default => 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6'
    };
?>

<div class="<?php echo e($gridClass); ?>">

    
    <?php $__currentLoopData = $metrics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3 p-6 flex flex-col justify-between">

            
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                <?php switch($key):

                    case ('customers'): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                             class="w-6 h-6 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor"
                             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <path d="M16 3.128a4 4 0 0 1 0 7.744"/>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                            <circle cx="9" cy="7" r="4"/>
                        </svg>
                        <?php break; ?>

                    <?php case ('vendors'): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-200"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 21V7l9-4 9 4v14"/>
                            <path d="M9 21V12h6v9"/>
                        </svg>
                        <?php break; ?>

                    <?php case ('orders'): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-200"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/>
                            <path d="M14 2v5a1 1 0 0 0 1 1h5"/>
                            <path d="M10 9H8M16 13H8M16 17H8"/>
                        </svg>
                        <?php break; ?>

                    <?php case ('products'): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-200"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"/>
                            <path d="m7.5 4.27 9 5.15"/>
                            <polyline points="3.29 7 12 12 20.71 7"/>
                            <line x1="12" y1="22" x2="12" y2="12"/>
                        </svg>
                        <?php break; ?>

                    <?php case ('pending'): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-amber-500"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        <?php break; ?>

                    <?php case ('processing'): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-500 animate-spin"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
                        </svg>
                        <?php break; ?>

                    <?php case ('shipped'): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-500"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="14" x="2" y="5" rx="2" ry="2"/>
                            <path d="M8 21h8M12 17v4"/>
                        </svg>
                        <?php break; ?>

                    <?php case ('delivered'): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-500"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 12l2 2 4-4"/>
                            <circle cx="12" cy="12" r="10"/>
                        </svg>
                        <?php break; ?>

                    <?php default: ?>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-200"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="20" x2="12" y2="10"/>
                            <line x1="18" y1="20" x2="18" y2="4"/>
                            <line x1="6" y1="20" x2="6" y2="16"/>
                        </svg>
                <?php endswitch; ?>
            </div>

            
            <div class="mt-5 flex items-end justify-between">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400"><?php echo e($m['label']); ?></span>
                    <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                        <?php echo e(number_format($m['count'])); ?>

                    </h4>

                    <?php if(in_array($role, ['admin','vendor']) && isset($m['change'])): ?>
                        <p class="text-xs text-gray-400">vs last week</p>
                    <?php endif; ?>
                </div>

                <?php if(in_array($role, ['admin','vendor']) && isset($m['change'])): ?>
                    <span class="flex items-center gap-1 rounded-full
                        <?php echo e($m['change'] >= 0
                            ? 'bg-green-100 text-green-600 dark:bg-green-500/15 dark:text-green-400'
                            : 'bg-red-100 text-red-600 dark:bg-red-500/15 dark:text-red-400'); ?>

                        py-0.5 px-2.5 text-sm font-medium">
                        <?php echo e($m['change'] >= 0 ? '+' : ''); ?><?php echo e($m['change']); ?>%
                    </span>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php if(in_array($role, ['admin','vendor'])): ?>
        <div class="col-span-4 rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3 p-6 flex flex-col justify-between">

            
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-6 h-6 text-emerald-600 dark:text-emerald-400"
                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 8c-2.28 0-4 .72-4 2.5S9.72 13 12 13s4 .72 4 2.5S14.28 18 12 18"/>
                    <path d="M12 3v3m0 12v3"/>
                </svg>
            </div>

            
            <div class="mt-5 flex items-end justify-between">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">Total Incomes (All Time)</span>
                    <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                        Rp <?php echo e(number_format($totalIncomesAllTime, 0, ',', '.')); ?>

                    </h4>
                </div>
            </div>

        </div>
    <?php endif; ?>

</div><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/components/metric-group-dashboard.blade.php ENDPATH**/ ?>