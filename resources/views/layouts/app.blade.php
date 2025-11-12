<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta
      name="viewport"
      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"
    />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('title', 'Dashboard') | {{ setting('site_name', 'Marketplace Timedoor') }}</title>
    <meta name="description" content="{{ setting('meta_description', 'A trusted digital marketplace for tech and creative products.') }}">
    <meta name="keywords" content="{{ setting('meta_keywords', 'marketplace, timedoor, ecommerce, digital') }}">
    <meta name="theme-color" content="#2563eb">

    <link rel="icon" type="image/x-icon" href="{{ setting('favicon', asset('images/placeholder-image.svg')) }}">
    <meta property="og:title" content="{{ setting('site_name', 'Marketplace Timedoor') }}">
    <meta property="og:description" content="{{ setting('meta_description', 'A trusted digital marketplace for tech and creative products.') }}">
    <meta property="og:image" content="{{ setting('og_image', asset('images/placeholder-image.svg')) }}">
    <meta property="og:type" content="website">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('css')

    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    {{-- Select2 & TinyMCE --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/{{ config('app.tinymce_api_key') }}/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
      /* Match Select2 to Tailwind input style */
      .select2-container .select2-selection--single {
        height: 42px !important;
        border: 1px solid #d1d5db !important; /* gray-300 */
        border-radius: 0.5rem !important; /* rounded-lg */
        display: flex !important;
        align-items: center !important;
        background-color: white !important;
      }

      .dark .select2-container .select2-selection--single {
        background-color: #111827 !important; /* dark:bg-gray-900 */
        border-color: #374151 !important; /* dark:border-gray-700 */
        color: #e5e7eb !important; /* dark:text-gray-200 */
      }

      .select2-container--default .select2-selection__rendered {
        color: inherit !important;
        font-size: 0.875rem !important;
        padding-left: 10px !important;
      }

      .select2-container--default .select2-selection__arrow {
        height: 38px !important;
        right: 10px !important;
      }

      .dark .select2-dropdown {
        background-color: #1f2937 !important;
        color: #e5e7eb !important;
      }
    </style>
  </head>
  <body
    x-data="{ page: 'ecommerce', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
    x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900': darkMode === true}"
  >
    <!-- ===== Preloader Start ===== -->
    <x-preloader></x-preloader>
    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
      <!-- ===== Sidebar Start ===== -->
      <x-sidebar></x-sidebar>
      <!-- ===== Sidebar End ===== -->

      <!-- ===== Content Area Start ===== -->
      <div
        class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto"
      >
        <!-- Small Device Overlay Start -->
        <x-overlay />
        <!-- Small Device Overlay End -->

        <!-- ===== Header Start ===== -->
        <x-header />
        <!-- ===== Header End ===== -->

        <!-- ===== Main Content Start ===== -->
        <main>
          <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
            @yield('content')
          </div>
        </main>
        <!-- ===== Main Content End ===== -->
      </div>
      <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->

    @stack('js')
  </body>
</html>