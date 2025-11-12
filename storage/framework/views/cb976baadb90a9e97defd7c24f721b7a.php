<aside
  :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
  class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
>
  <!-- SIDEBAR HEADER -->
  <div
    :class="sidebarToggle ? 'justify-center' : 'justify-between'"
    class="flex items-center justify-center gap-2 pt-8 pb-7"
  >
    <a href="<?php echo e(route('dashboard.index')); ?>">
      <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
        <img 
          class="w-24 rounded-full object-cover border"
          src="<?php echo e(setting('site_logo', asset('images/placeholder-image.svg'))); ?>" 
          alt="<?php echo e(setting('site_name', 'Marketplace Timedoor')); ?>" 
        />
      </span>
      <img
        class="w-18 rounded-full object-cover border"
        :class="sidebarToggle ? 'lg:block' : 'hidden'"
        src="<?php echo e(setting('logo_icon', asset('images/placeholder-image.svg'))); ?>"
        alt="Logo"
      />
    </a>
  </div>

  <div class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar">
    <nav>

      
      <?php if(auth()->user()?->admin || auth()->user()?->vendor): ?>
        <div>
          <h3 class="mb-4 text-xs uppercase leading-5 text-gray-400"
            :class="sidebarToggle ? 'lg:hidden' : ''">Statistics</h3>
          <ul class="flex flex-col gap-4 mb-6">
            <li>
              <a href="<?php echo e(route('dashboard.index')); ?>"
                class="menu-item group <?php echo e(request()->is('dashboard') ? 'menu-item-active' : 'menu-item-inactive'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="menu-item-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chart-line-icon lucide-chart-line"><path d="M3 3v16a2 2 0 0 0 2 2h16"/><path d="m19 9-5 5-4-4-3 3"/></svg>
                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Dashboard</span>
              </a>
            </li>
          </ul>
        </div>
      <?php endif; ?>

      
      <?php if(auth()->user()?->admin): ?>
        <div>
          <h3 class="mb-4 text-xs uppercase leading-5 text-gray-400"
            :class="sidebarToggle ? 'lg:hidden' : ''">Master Data</h3>
          <ul class="flex flex-col gap-4 mb-6">
            <li>
              <a href="<?php echo e(route('categories.index')); ?>"
                class="menu-item group <?php echo e(request()->is('dashboard/categories*') ? 'menu-item-active' : 'menu-item-inactive'); ?>">
                <svg class="menu-item-icon" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M4 4h16v16H4z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                  <path d="M4 9h16M9 4v16" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Categories</span>
              </a>
            </li>

            <li>
              <a href="<?php echo e(route('products.index')); ?>"
                class="menu-item group <?php echo e(request()->is('dashboard/products*') ? 'menu-item-active' : 'menu-item-inactive'); ?>">
                <svg class="menu-item-icon" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M4 4h16v16H4z" stroke="currentColor" stroke-width="1.5"/>
                  <path d="M9 4v16M4 9h16" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Products</span>
              </a>
            </li>

            <li>
              <a href="<?php echo e(route('orders.index')); ?>"
                class="menu-item group <?php echo e(request()->is('dashboard/orders*') ? 'menu-item-active' : 'menu-item-inactive'); ?>">
                <svg class="menu-item-icon" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path d="M5 5h14v14H5z" stroke="currentColor" stroke-width="1.5"/>
                  <path d="M8 8h8M8 12h5" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Orders</span>
              </a>
            </li>
          </ul>
        </div>
      <?php endif; ?>

      
      <?php if(auth()->user()?->vendor): ?>
        <div>
          <h3 class="mb-4 text-xs uppercase leading-5 text-gray-400"
            :class="sidebarToggle ? 'lg:hidden' : ''">My Business</h3>
          <ul class="flex flex-col gap-4 mb-6">
            <li>
              <a href="<?php echo e(route('products.index')); ?>"
                class="menu-item group <?php echo e(request()->is('dashboard/products*') ? 'menu-item-active' : 'menu-item-inactive'); ?>">
                <svg class="menu-item-icon" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M4 4h16v16H4z" stroke="currentColor" stroke-width="1.5"/>
                  <path d="M9 4v16M4 9h16" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Products</span>
              </a>
            </li>
            <li>
              <a href="<?php echo e(route('orders.index')); ?>"
                class="menu-item group <?php echo e(request()->is('dashboard/orders*') ? 'menu-item-active' : 'menu-item-inactive'); ?>">
                <svg class="menu-item-icon" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path d="M5 5h14v14H5z" stroke="currentColor" stroke-width="1.5"/>
                  <path d="M8 8h8M8 12h5" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Orders</span>
              </a>
            </li>
          </ul>
        </div>
      <?php endif; ?>

      
      <?php if(auth()->user()?->admin): ?>
        <div>
          <h3 class="mb-4 text-xs uppercase leading-5 text-gray-400"
            :class="sidebarToggle ? 'lg:hidden' : ''">User</h3>
          <ul class="flex flex-col gap-4 mb-6">
            <li>
              <a href="<?php echo e(route('vendors.index')); ?>"
                class="menu-item group <?php echo e(request()->is('dashboard/vendors*') ? 'menu-item-active' : 'menu-item-inactive'); ?>">
                <svg class="menu-item-icon" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path d="M12 12a4 4 0 100-8 4 4 0 000 8z" stroke="currentColor" stroke-width="1.5"/>
                  <path d="M6 20a6 6 0 0112 0H6z" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Vendors</span>
              </a>
            </li>
            <li>
              <a href="<?php echo e(route('customers.index')); ?>"
                class="menu-item group <?php echo e(request()->is('dashboard/customers*') ? 'menu-item-active' : 'menu-item-inactive'); ?>">
                <svg class="menu-item-icon" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path d="M12 12a4 4 0 100-8 4 4 0 000 8z" stroke="currentColor" stroke-width="1.5"/>
                  <path d="M6 20a6 6 0 0112 0H6z" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Customers</span>
              </a>
            </li>
          </ul>
        </div>
      <?php endif; ?>

      
      <?php if(auth()->user()?->admin || auth()->user()?->vendor): ?>
        <div>
          <h3 class="mb-4 text-xs uppercase leading-5 text-gray-400"
            :class="sidebarToggle ? 'lg:hidden' : ''">Settings</h3>
          <ul class="flex flex-col gap-4 mb-6">
            <li>
              <a href="<?php echo e(route('profile.edit')); ?>"
                class="menu-item group <?php echo e(request()->routeIs('profile.edit') ? 'menu-item-active' : 'menu-item-inactive'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="menu-item-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-cog-icon lucide-user-round-cog"><path d="m14.305 19.53.923-.382"/><path d="m15.228 16.852-.923-.383"/><path d="m16.852 15.228-.383-.923"/><path d="m16.852 20.772-.383.924"/><path d="m19.148 15.228.383-.923"/><path d="m19.53 21.696-.382-.924"/><path d="M2 21a8 8 0 0 1 10.434-7.62"/><path d="m20.772 16.852.924-.383"/><path d="m20.772 19.148.924.383"/><circle cx="10" cy="8" r="5"/><circle cx="18" cy="18" r="3"/></svg>
                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Edit Profile</span>
              </a>
            </li>

            <?php if(auth()->user()?->admin): ?>
              <li>
                <a href="<?php echo e(route('settings.index')); ?>"
                  class="menu-item group <?php echo e(request()->is('dashboard/settings*') ? 'menu-item-active' : 'menu-item-inactive'); ?>">
                  <svg xmlns="http://www.w3.org/2000/svg" class="menu-item-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-settings-icon lucide-settings"><path d="M9.671 4.136a2.34 2.34 0 0 1 4.659 0 2.34 2.34 0 0 0 3.319 1.915 2.34 2.34 0 0 1 2.33 4.033 2.34 2.34 0 0 0 0 3.831 2.34 2.34 0 0 1-2.33 4.033 2.34 2.34 0 0 0-3.319 1.915 2.34 2.34 0 0 1-4.659 0 2.34 2.34 0 0 0-3.32-1.915 2.34 2.34 0 0 1-2.33-4.033 2.34 2.34 0 0 0 0-3.831A2.34 2.34 0 0 1 6.35 6.051a2.34 2.34 0 0 0 3.319-1.915"/><circle cx="12" cy="12" r="3"/></svg>
                  <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Web Settings</span>
                </a>
              </li>
            <?php endif; ?>
          </ul>
        </div>
      <?php endif; ?>

    </nav>
  </div>
</aside><?php /**PATH /Users/gusde/Documents/laravel/marketplace-timedoor/resources/views/components/sidebar.blade.php ENDPATH**/ ?>