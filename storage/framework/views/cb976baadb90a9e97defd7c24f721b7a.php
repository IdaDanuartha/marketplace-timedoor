<aside
  :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
  class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
>
  <!-- SIDEBAR HEADER -->
  <div
    :class="sidebarToggle ? 'justify-center' : 'justify-between'"
    class="flex items-center gap-2 pt-8 sidebar-header pb-7"
  >
    <a href="<?php echo e(route('dashboard.index')); ?>">
      <span class="logo" :class="sidebarToggle ? 'hidden' : ''">
        <img class="dark:hidden" src="/images/logo/logo.svg" alt="Logo" />
        <img class="hidden dark:block" src="/images/logo/logo-dark.svg" alt="Logo" />
      </span>
      <img
        class="logo-icon"
        :class="sidebarToggle ? 'lg:block' : 'hidden'"
        src="/images/logo/logo-icon.svg"
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
                <svg class="menu-item-icon" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8v-10h-8v10zm0-18v6h8V3h-8z" fill="currentColor"/>
                </svg>
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
                <svg class="menu-item-icon" width="24" height="24" fill="none" viewBox="0 0 24 24">
                  <path d="M12 12a4 4 0 100-8 4 4 0 000 8z" stroke="currentColor" stroke-width="1.5"/>
                  <path d="M6 20a6 6 0 0112 0H6z" stroke="currentColor" stroke-width="1.5"/>
                </svg>
                <span class="menu-item-text" :class="sidebarToggle ? 'lg:hidden' : ''">Edit Profile</span>
              </a>
            </li>

            <?php if(auth()->user()?->admin): ?>
              <li>
                <a href="<?php echo e(route('settings.index')); ?>"
                  class="menu-item group <?php echo e(request()->is('dashboard/settings*') ? 'menu-item-active' : 'menu-item-inactive'); ?>">
                  <svg class="menu-item-icon" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path d="M12 3v18m9-9H3" stroke="currentColor" stroke-width="1.5"/>
                  </svg>
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