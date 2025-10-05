<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="cupcake" class="scroll-smooth">
{{-- Default theme set to 'cupcake' for a softer feel --}}

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>

    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/apple-icon.png') }}" />
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.png') }}" />

    @include('dashboard.layouts.link')
    @yield('css')
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- DaisyUI Theme Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // 1. Ambil tema dari localStorage atau default ke 'cupcake'
            const savedTheme = localStorage.getItem('theme') || 'cupcake';

            // 2. Terapkan tema ke elemen <html>
            document.documentElement.setAttribute('data-theme', savedTheme);

            // 3. Fungsi untuk mengatur tema dan menyimpannya ke localStorage
            window.setTheme = function(theme) {
                document.documentElement.setAttribute('data-theme', theme);
                localStorage.setItem('theme', theme);
                // Opsional: Jika Anda ingin menutup dropdown setelah memilih
                // document.activeElement.blur();
            };

            // 4. Tandai radio button yang sesuai dengan tema yang sedang aktif
            const themeRadios = document.querySelectorAll('input[name="theme-dropdown"].theme-controller');
            themeRadios.forEach(radio => {
                if (radio.value === savedTheme) {
                    radio.checked = true;
                }
                // Tambahkan event listener untuk setiap radio button
                radio.addEventListener('change', (event) => {
                    window.setTheme(event.target.value);
                });
            });
        });
    </script>
</head>

{{-- Body styling for a softer background and rounded feel --}}

<body class="bg-base-100 text-base-content font-sans antialiased">
    {{-- Background element for a clean, slightly rounded header area --}}
    <div
        class="min-h-75 absolute w-full bg-blue-500 bg-y-50 top-0 min-h-75 bg-[url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg')] dark:bg-[url('https://raw.githubusercontent.com/creativetimofficial/public-assets/master/argon-dashboard-pro/assets/img/profile-layout-header.jpg')]">
        <span class="absolute top-0 left-0 w-full h-full bg-base-100 opacity-80"></span> 
    </div>

    {{-- BG NO IMAGE --}}
    {{-- <div class="min-h-75 absolute w-full top-0 min-h-75 bg-base-300"> 
        <span class="absolute top-0 left-0 w-full h-full bg-base-content opacity-10"></span> 
    </div> --}}



    @include('dashboard.layouts.sidebar')

    <main class="xl:ml-68 relative h-full max-h-screen rounded-xl transition-all duration-200 ease-in-out z-10">
        {{-- Add z-10 to bring content above background --}}
        @include('dashboard.layouts.navbar')

        <div class="mx-auto w-full px-6 py-6">
            @yield('container')
            @include('dashboard.layouts.footer')
        </div>
    </main>

    @include('dashboard.layouts.script')
    @yield('js')

     {{-- =========================================
         🔹 GLOBAL LOADING OVERLAY
    ========================================== --}}
    <div id="global-loading-overlay" 
        class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-[9999] transition-opacity duration-300">
        <div class="flex flex-col items-center">
            <svg class="animate-spin h-10 w-10 text-white mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 018 8h-4l3 3-3 3h4a8 8 0 01-8 8v-4l-3 3 3 3v-4a8 8 0 01-8-8H4z"></path>
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
</body>

</html>
