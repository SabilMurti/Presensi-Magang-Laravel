<nav x-data="{ open: false }" class="bg-base-100 border-b border-base-200 shadow-sm sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-primary" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        <span class="text-base-content hover:text-primary transition duration-150 ease-in-out">{{ __('Dashboard') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('admin.karyawan')" :active="request()->routeIs('admin.karyawan')">
                        <span class="text-base-content hover:text-primary transition duration-150 ease-in-out">{{ __('Data Karyawan') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('admin.departemen')" :active="request()->routeIs('admin.departemen')">
                        <span class="text-base-content hover:text-primary transition duration-150 ease-in-out">{{ __('Data Instansi') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('admin.monitoring-presensi')" :active="request()->routeIs('admin.monitoring-presensi')">
                        <span class="text-base-content hover:text-primary transition duration-150 ease-in-out">{{ __('Monitoring Presensi') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('admin.laporan.presensi')" :active="request()->routeIs('admin.laporan.presensi')">
                        <span class="text-base-content hover:text-primary transition duration-150 ease-in-out">{{ __('Laporan Presensi') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('admin.lokasi-kantor')" :active="request()->routeIs('admin.lokasi-kantor')">
                        <span class="text-base-content hover:text-primary transition duration-150 ease-in-out">{{ __('Lokasi Kantor') }}</span>
                    </x-nav-link>
                    <x-nav-link :href="route('admin.administrasi-presensi')" :active="request()->routeIs('admin.administrasi-presensi')">
                        <span class="text-base-content hover:text-primary transition duration-150 ease-in-out">{{ __('Administrasi Presensi') }}</span>
                    </x-nav-link>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <!-- Theme Changer -->
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343h7.071m-4.634 0L19 19m-2-2l2-2m-2-2l2-2" />
                        </svg>
                    </div>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 z-[1]">
                        <li><input type="radio" name="theme-dropdown" class="theme-controller btn btn-sm btn-block btn-ghost justify-start" aria-label="Default" value="light"/></li>
                        <li><input type="radio" name="theme-dropdown" class="theme-controller btn btn-sm btn-block btn-ghost justify-start" aria-label="Dark" value="dark"/></li>
                        <li><input type="radio" name="theme-dropdown" class="theme-controller btn btn-sm btn-block btn-ghost justify-start" aria-label="Cupcake" value="cupcake"/></li>
                        <li><input type="radio" name="theme-dropdown" class="theme-controller btn btn-sm btn-block btn-ghost justify-start" aria-label="Valentine" value="valentine"/></li>
                        <li><input type="radio" name="theme-dropdown" class="theme-controller btn btn-sm btn-block btn-ghost justify-start" aria-label="Emerald" value="emerald"/></li>
                        <li><input type="radio" name="theme-dropdown" class="theme-controller btn btn-sm btn-block btn-ghost justify-start" aria-label="Autumn" value="autumn"/></li>
                        <li><input type="radio" name="theme-dropdown" class="theme-controller btn btn-sm btn-block btn-ghost justify-start" aria-label="Garden" value="garden"/></li>
                        <li><input type="radio" name="theme-dropdown" class="theme-controller btn btn-sm btn-block btn-ghost justify-start" aria-label="Forest" value="forest"/></li>
                        <li><input type="radio" name="theme-dropdown" class="theme-controller btn btn-sm btn-block btn-ghost justify-start" aria-label="Lofi" value="lofi"/></li>
                        <li><input type="radio" name="theme-dropdown" class="theme-controller btn btn-sm btn-block btn-ghost justify-start" aria-label="Pastel" value="pastel"/></li>
                    </ul>
                </div>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-base-content bg-base-100 hover:text-primary focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-base-content hover:text-primary hover:bg-base-200 focus:outline-none focus:bg-base-200 focus:text-primary transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-base-100 border-t border-base-200">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                <span class="text-base-content hover:text-primary transition duration-150 ease-in-out">{{ __('Dashboard') }}</span>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.karyawan')" :active="request()->routeIs('admin.karyawan')">
                <span class="text-base-content hover:text-primary transition duration-150 ease-in-out">{{ __('Data Karyawan') }}</span>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.departemen')" :active="request()->routeIs('admin.departemen')">
                <span class="text-base-content hover:text-primary transition duration-150 ease-in-out">{{ __('Data Instansi') }}</span>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.monitoring-presensi')" :active="request()->routeIs('admin.monitoring-presensi')">
                <span class="text-base-content hover:text-primary transition duration-150 ease-in-out">{{ __('Monitoring Presensi') }}</span>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.laporan.presensi')" :active="request()->routeIs('admin.laporan.presensi')">
                <span class="text-base-content hover:text-primary transition duration-150 ease-in-out">{{ __('Laporan Presensi') }}</span>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.lokasi-kantor')" :active="request()->routeIs('admin.lokasi-kantor')">
                <span class="text-base-content hover:text-primary transition duration-150 ease-in-out">{{ __('Lokasi Kantor') }}</span>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.administrasi-presensi')" :active="request()->routeIs('admin.administrasi-presensi')">
                <span class="text-base-content hover:text-primary transition duration-150 ease-in-out">{{ __('Administrasi Presensi') }}</span>
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-base-200">
            <div class="px-4">
                <div class="font-medium text-base text-base-content">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-base-content-secondary">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>