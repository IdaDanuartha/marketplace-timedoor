@php
    $user = auth()->user();
    $role = $user->admin ? 'admin' : ($user->vendor ? 'vendor' : 'customer');

    $gridClass = match ($role) {
        'admin' => 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6',
        'vendor' => 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-6',
        'customer' => 'grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6',
        default => 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6'
    };
@endphp

<div class="{{ $gridClass }}">
    @foreach ($metrics as $key => $m)
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-white/3 p-6 flex flex-col justify-between">
            {{-- === Icon === --}}
            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gray-100 dark:bg-gray-800">
                @switch($key)
                    @case('customers')
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-6 h-6 text-gray-700 dark:text-gray-200" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                            <path d="M16 3.128a4 4 0 0 1 0 7.744"/>
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                            <circle cx="9" cy="7" r="4"/>
                        </svg>
                        @break

                    @case('vendors')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 21V7l9-4 9 4v14"/>
                            <path d="M9 21V12h6v9"/>
                        </svg>
                        @break

                    @case('orders')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/>
                            <path d="M14 2v5a1 1 0 0 0 1 1h5"/>
                            <path d="M10 9H8M16 13H8M16 17H8"/>
                        </svg>
                        @break

                    @case('products')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"/>
                            <path d="m7.5 4.27 9 5.15"/>
                            <polyline points="3.29 7 12 12 20.71 7"/>
                            <line x1="12" y1="22" x2="12" y2="12"/>
                        </svg>
                        @break

                    @case('pending')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        @break

                    @case('processing')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-500 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 12a9 9 0 1 1-6.219-8.56"/>
                        </svg>
                        @break

                    @case('shipped')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect width="20" height="14" x="2" y="5" rx="2" ry="2"/>
                            <path d="M8 21h8M12 17v4"/>
                        </svg>
                        @break

                    @case('delivered')
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 12l2 2 4-4"/>
                            <circle cx="12" cy="12" r="10"/>
                        </svg>
                        @break

                    @default
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-700 dark:text-gray-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="20" x2="12" y2="10"/>
                            <line x1="18" y1="20" x2="18" y2="4"/>
                            <line x1="6" y1="20" x2="6" y2="16"/>
                        </svg>
                @endswitch
            </div>

            {{-- === Metric Text === --}}
            <div class="mt-5 flex items-end justify-between">
                <div>
                    <span class="text-sm text-gray-500 dark:text-gray-400">{{ $m['label'] }}</span>
                    <h4 class="mt-2 text-title-sm font-bold text-gray-800 dark:text-white/90">
                        {{ number_format($m['count']) }}
                    </h4>

                    {{-- Show percent only for admin/vendor --}}
                    @if(in_array($role, ['admin','vendor']) && isset($m['change']))
                        <p class="text-xs text-gray-400">vs last week</p>
                    @endif
                </div>

                @if(in_array($role, ['admin','vendor']) && isset($m['change']))
                    <span
                        class="flex items-center gap-1 rounded-full 
                            {{ $m['change'] >= 0
                                ? 'bg-green-100 text-green-600 dark:bg-green-500/15 dark:text-green-400'
                                : 'bg-red-100 text-red-600 dark:bg-red-500/15 dark:text-red-400' }}
                            py-0.5 px-2.5 text-sm font-medium">
                        {{ $m['change'] >= 0 ? '+' : '' }}{{ $m['change'] }}%
                    </span>
                @endif
            </div>
        </div>
    @endforeach
</div>