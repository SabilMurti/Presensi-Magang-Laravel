<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="cupcake"> {{-- Default theme set to 'cupcake' for a soft, modern feel --}}

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel Presensi') }}</title>

    <!-- Fonts - Using Inter from Google Fonts for a modern, clean look -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    {{-- Jika Anda ingin menggunakan font yang lebih playful seperti Poppins atau Varela Round, bisa ditambahkan di sini --}}

    <!-- Remixicon Icons - Pastikan sudah diinstal atau di-link -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        // Script untuk mengatur tema dari localStorage atau default
        const savedTheme = localStorage.getItem('theme') || 'cupcake'; // Default to 'cupcake' or any soft theme
        document.documentElement.setAttribute('data-theme', savedTheme);

        // Listener untuk tombol ganti tema di navigation.blade.php
        document.addEventListener('DOMContentLoaded', () => {
            const themeControllers = document.querySelectorAll('.theme-controller');
            themeControllers.forEach(controller => {
                if (controller.value === savedTheme) {
                    controller.checked = true;
                }
                controller.addEventListener('change', (e) => {
                    const newTheme = e.target.value;
                    document.documentElement.setAttribute('data-theme', newTheme);
                    localStorage.setItem('theme', newTheme);
                });
            });
        });
    </script>
    @stack('styles')

</head>

<body class="font-sans antialiased text-base-content min-h-screen bg-base-200"> {{-- Global background and text color --}}
    <div class="min-h-screen bg-base-200"> {{-- Ensure body and outer div use theme background --}}
        @include('admin.layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-base-100 shadow-sm border-b border-base-200"> {{-- Header uses theme background --}}
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    {{-- =========================================
         🔹 GLOBAL LOADING OVERLAY
    ========================================== --}}
    <div id="global-loading-overlay"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-[9999] transition-opacity duration-300">
        <div class="flex flex-col items-center">
            <svg class="animate-spin h-10 w-10 text-white mb-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 018 8h-4l3 3-3 3h4a8 8 0 01-8 8v-4l-3 3 3 3v-4a8 8 0 01-8-8H4z">
                </path>
            </svg>
            <p class="text-white text-lg font-semibold">Memproses...</p>
        </div>
    </div>

    {{-- =========================================
         🔹 SCRIPT GLOBAL
    ========================================== --}}
    <script>
        // === AJAX: tampilkan overlay saat request jalan ===
        $(document).ajaxStart(function() {
            $('#global-loading-overlay').removeClass('hidden').addClass('flex');
        });
        $(document).ajaxStop(function() {
            $('#global-loading-overlay').removeClass('flex').addClass('hidden');
        });

        // === Form submit manual ===
        $(document).on('submit', 'form', function() {
            $('#global-loading-overlay').removeClass('hidden').addClass('flex');
        });

        // === Saat halaman baru dimuat, overlay muncul dulu ===
        window.addEventListener('beforeunload', function() {
            $('#global-loading-overlay').removeClass('hidden').addClass('flex');
        });

        // === Sembunyikan overlay setelah halaman selesai render ===
        window.addEventListener('load', function() {
            $('#global-loading-overlay').addClass('hidden').removeClass('flex');
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    @stack('scripts')

    {{-- SweetAlert2 dan library JS lain dapat ditambahkan di sini jika perlu --}}
</body>

</html>
