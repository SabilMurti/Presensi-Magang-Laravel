<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-base-200 text-base-content">

    {{-- HANYA JUDUL "PRESENSI MAGANG SMK 9 dan 2 tombol login" --}}
    <div class="min-h-screen flex flex-col items-center justify-center bg-base-200">
        
    <h1 class="text-2xl font-bold">PRESENSI MAGANG SMK 9</h1>
    @if (Route::has('login'))
        <div class="card mt-6 flex gap-4">
            @auth
                <a href="{{ url('/admin/dashboard') }}"
                    class="btn btn-primary btn-md rounded-full shadow-md hover:shadow-lg transition-all duration-200">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="btn btn-primary btn-md rounded-full shadow-md hover:shadow-lg transition-all duration-200">
                    Login Admin
                </a>

                @if (Route::has('login.view'))
                    <a href="{{ route('login.view') }}"
                        class="btn btn-primary btn-md rounded-full shadow-md hover:shadow-lg transition-all duration-200">
                        Login Karyawan
                    </a>
                @endif
            @endauth
            </nav>
    @endif
    </div>
</body>

</html>
