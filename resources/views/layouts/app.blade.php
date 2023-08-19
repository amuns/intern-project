<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="meta_title" content="@yield('meta_title')">
    <meta name="meta_description" content="@yield('meta_description')">
    <meta name="keywords" content="@yield('keywords')">

    <title>{{ config('app.name', 'Laravel E-commerce Website') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/footer.css', 'resources/sass/style.scss', 'resources/css/header.css'])
    @vite(['resources/css/theme.css'])

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body>
    @yield('header')

    <main class="">
        {{ $slot }}
    </main>

    <!-- Toast -->
    <div x-data="toast" x-show="visible" x-transition x-cloak @notify.window="show($event.detail.message)"
        class="fixed w-[400px] left-1/2 z-40 -ml-[200px] top-16 py-2 px-4 pb-4 bg-emerald-500 text-white">
        <div class="font-semibold" x-text="message"></div>
        <button @click="close"
            class="absolute flex items-center justify-center right-2 top-2 w-[30px] h-[30px] rounded-full hover:bg-black/10 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <!-- Progress -->
        <div>
            <div class="absolute left-0 bottom-0 right-0 h-[6px] bg-black/10" :style="{ 'width': `${percent}%` }"></div>
        </div>
    </div>
    <!--/ Toast -->
    
</body>

</html>
