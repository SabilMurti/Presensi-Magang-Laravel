<aside class="ease-nav-brand z-990 fixed inset-y-0 my-4 block max-w-64 w-full -translate-x-full flex-wrap items-center justify-between overflow-y-auto rounded-3xl border-0 bg-base-100 p-0 antialiased shadow-lg shadow-base-content/20 transition-transform duration-200 xl:left-0 xl:ml-6 xl:translate-x-0" aria-expanded="false">
    <div class="h-19 border-b border-base-200">
        <i class="ri-close-large-fill absolute right-0 top-0 cursor-pointer p-4 text-base-content opacity-50 xl:hidden" sidenav-close></i>
        <a class="m-0 block whitespace-nowrap px-8 py-6 text-sm text-base-content" href="{{ route('karyawan.dashboard') }}">
            {{-- Sesuaikan logo agar selalu terlihat di dark/light mode --}}
            <img src="{{ asset('img/logo-ct-dark.png') }}" class="ease-nav-brand inline h-full max-h-8 max-w-full transition-all duration-200 theme-light:inline theme-dark:hidden" alt="main_logo" />
            <img src="{{ asset('img/logo-ct.png') }}" class="ease-nav-brand hidden h-full max-h-8 max-w-full transition-all duration-200 theme-light:hidden theme-dark:inline" alt="main_logo" />
            <span class="ease-nav-brand ml-1 font-semibold transition-all duration-200">Laravel Presensi</span>
        </a>
    </div>

    <hr class="mt-0 h-px bg-transparent bg-gradient-to-r from-transparent via-base-300 to-transparent" />

    <div class="h-sidenav block max-h-screen w-auto grow basis-full items-center overflow-auto">
        <ul class="mb-0 flex flex-col pl-0">
            <li class="mt-0.5 w-full">
                <a class="py-2.7 ease-nav-brand mx-2 my-0 flex items-center whitespace-nowrap px-4 text-sm transition-colors text-base-content {{ Request::routeIs(['karyawan.dashboard']) ? 'rounded-xl font-semibold bg-primary-focus bg-opacity-15 text-primary' : 'hover:bg-base-200 rounded-xl' }}" href="{{ route('karyawan.dashboard') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-base-200 stroke-0 text-center xl:p-2.5">
                        <i class="ri-tv-2-line relative top-0 text-lg leading-normal text-primary"></i>
                    </div>
                    <span class="ease pointer-events-none ml-1 opacity-100 duration-300">Dashboard</span>
                </a>
            </li>

            <li class="mt-0.5 w-full">
                <a class="py-2.7 ease-nav-brand mx-2 my-0 flex items-center whitespace-nowrap px-4 text-sm transition-colors text-base-content {{ Request::routeIs(['karyawan.presensi']) ? 'rounded-xl font-semibold bg-primary-focus bg-opacity-15 text-primary' : 'hover:bg-base-200 rounded-xl' }}" href="{{ route('karyawan.presensi') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-base-200 stroke-0 text-center xl:p-2.5">
                        <i class="ri-camera-fill relative top-0 text-lg leading-normal text-secondary"></i>
                    </div>
                    <span class="ease pointer-events-none ml-1 opacity-100 duration-300">Presensi</span>
                </a>
            </li>

            <li class="mt-0.5 w-full">
                <a class="py-2.7 ease-nav-brand mx-2 my-0 flex items-center whitespace-nowrap px-4 text-sm transition-colors text-base-content {{ Request::routeIs(['karyawan.history']) ? 'rounded-xl font-semibold bg-primary-focus bg-opacity-15 text-primary' : 'hover:bg-base-200 rounded-xl' }}" href="{{ route('karyawan.history') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-base-200 stroke-0 text-center xl:p-2.5">
                        <i class="ri-history-fill relative top-0 text-lg leading-normal text-accent"></i>
                    </div>
                    <span class="ease pointer-events-none ml-1 opacity-100 duration-300">History</span>
                </a>
            </li>

            <li class="mt-0.5 w-full">
                <a class="py-2.7 ease-nav-brand mx-2 my-0 flex items-center whitespace-nowrap px-4 text-sm transition-colors text-base-content {{ Request::routeIs(['karyawan.izin', 'karyawan.izin.create']) ? 'rounded-xl font-semibold bg-primary-focus bg-opacity-15 text-primary' : 'hover:bg-base-200 rounded-xl' }}" href="{{ route('karyawan.izin') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-base-200 stroke-0 text-center xl:p-2.5">
                        <i class="ri-calendar-close-fill relative top-0 text-lg leading-normal text-error"></i>
                    </div>
                    <span class="ease pointer-events-none ml-1 opacity-100 duration-300">Izin</span>
                </a>
            </li>

            <li class="mt-0.5 w-full">
                <a class="py-2.7 ease-nav-brand mx-2 my-0 flex items-center whitespace-nowrap px-4 text-sm transition-colors text-base-content {{ Request::routeIs(['karyawan.profile']) ? 'rounded-xl font-semibold bg-primary-focus bg-opacity-15 text-primary' : 'hover:bg-base-200 rounded-xl' }}" href="{{ route('karyawan.profile') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-base-200 stroke-0 text-center xl:p-2.5">
                        <i class="ri-user-3-fill relative top-0 text-lg leading-normal text-info"></i>
                    </div>
                    <span class="ease pointer-events-none ml-1 opacity-100 duration-300">Profile</span>
                </a>
            </li>

            <li class="mt-0.5 w-full">
                <form method="POST" action="{{ route('logout.auth') }}">
                    @csrf
                    <button type="submit" class="py-2.7 ease-nav-brand mx-2 my-0 flex items-center whitespace-nowrap px-4 text-sm transition-colors text-base-content hover:bg-base-200 rounded-xl">
                        <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-base-200 stroke-0 text-center xl:p-2.5">
                            <i class="ri-logout-box-line relative top-0 text-lg leading-normal text-warning"></i>
                        </div>
                        <span class="ease pointer-events-none ml-1 opacity-100 duration-300">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</aside>