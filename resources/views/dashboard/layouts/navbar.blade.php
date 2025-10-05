<nav class="duration-250 relative mx-6 flex flex-wrap items-center justify-between rounded-2xl px-0 py-2 shadow-none transition-all ease-in lg:flex-nowrap lg:justify-start"
    navbar-main navbar-scroll="false">
    <div class="flex-wrap-inherit mx-auto flex w-full items-center justify-between px-4 py-1">
        <nav>
            <!-- breadcrumb -->
            <ol class="mr-12 flex flex-wrap rounded-lg bg-transparent pt-1 sm:mr-16">
                <li class="text-sm leading-normal">
                    <a class="text-base-content opacity-70" href="javascript:;">Pages</a> {{-- Menggunakan text-base-content --}}
                </li>
                <li class="pl-2 text-sm capitalize leading-normal text-base-content before:float-left before:pr-2 before:text-base-content before:content-['/']"
                    aria-current="page">{{ $title }}</li> {{-- Menggunakan text-base-content --}}
            </ol>
            <h6 class="mb-0 font-bold capitalize text-base-content">{{ $title }}</h6> {{-- Menggunakan text-base-content --}}
        </nav>

        <div class="mt-2 flex grow items-center sm:mr-6 sm:mt-0 md:mr-0 lg:flex lg:basis-auto">
            <div class="flex items-center md:ml-auto md:pr-4">

            </div>
            <ul class="md-max:w-full mb-0 flex list-none flex-row justify-end pl-0">
                <!-- Theme Changer -->
                <li class="flex items-center">
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle text-base-content">
                            {{-- Tambah text-base-content --}}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343h7.071m-4.634 0L19 19m-2-2l2-2m-2-2l2-2" />
                            </svg>
                        </div>
                        <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 z-[1]">
                            <li><input type="radio" name="theme-dropdown"
                                    class="theme-controller btn btn-sm btn-block btn-ghost justify-start"
                                    aria-label="Default" value="light" /></li>
                            <li><input type="radio" name="theme-dropdown"
                                    class="theme-controller btn btn-sm btn-block btn-ghost justify-start"
                                    aria-label="Dark" value="dark" /></li>
                            <li><input type="radio" name="theme-dropdown"
                                    class="theme-controller btn btn-sm btn-block btn-ghost justify-start"
                                    aria-label="Cupcake" value="cupcake" /></li>
                            <li><input type="radio" name="theme-dropdown"
                                    class="theme-controller btn btn-sm btn-block btn-ghost justify-start"
                                    aria-label="Valentine" value="valentine" /></li>
                            <li><input type="radio" name="theme-dropdown"
                                    class="theme-controller btn btn-sm btn-block btn-ghost justify-start"
                                    aria-label="Emerald" value="emerald" /></li>
                            <li><input type="radio" name="theme-dropdown"
                                    class="theme-controller btn btn-sm btn-block btn-ghost justify-start"
                                    aria-label="Autumn" value="autumn" /></li>
                            <li><input type="radio" name="theme-dropdown"
                                    class="theme-controller btn btn-sm btn-block btn-ghost justify-start"
                                    aria-label="Garden" value="garden" /></li>
                            <li><input type="radio" name="theme-dropdown"
                                    class="theme-controller btn btn-sm btn-block btn-ghost justify-start"
                                    aria-label="Forest" value="forest" /></li>
                            <li><input type="radio" name="theme-dropdown"
                                    class="theme-controller btn btn-sm btn-block btn-ghost justify-start"
                                    aria-label="Lofi" value="lofi" /></li>
                            <li><input type="radio" name="theme-dropdown"
                                    class="theme-controller btn btn-sm btn-block btn-ghost justify-start"
                                    aria-label="Pastel" value="pastel" /></li>
                        </ul>
                    </div>
                </li>
                <li class="flex items-center pl-4 xl:pr-4">
                    <a href="{{ route('karyawan.profile') }}"
                        class="ease-nav-brand block px-0 py-2 text-sm font-semibold text-base-content transition-all">
                        {{-- Menggunakan text-base-content --}}
                        @if (Auth::guard('karyawan')->user()->foto)
                            <div class="avatar">
                                <div class="w-10 rounded-full">
                                    <img
                                        src="{{ asset('storage/unggah/karyawan/' . Auth::guard('karyawan')->user()->foto) }}" />
                                </div>
                            </div>
                        @else
                            <i class="ri-user-3-fill sm:mr-1"></i>
                        @endif

                    </a>
                    {{-- bold --}}
                    <span class="m-3 font-bold hidden sm:inline">{{ Auth::guard('karyawan')->user()->nama_lengkap }}</span>
                </li>
                <li class="flex items-center px-4 xl:hidden">
                    <a href="javascript:;" class="ease-nav-brand block p-0 text-sm text-base-content transition-all"
                        sidenav-trigger> {{-- Menggunakan text-base-content --}}
                        <div class="w-4.5 overflow-hidden">
                            <i class="ease mb-0.75 relative block h-0.5 rounded-sm bg-base-content transition-all"></i>
                            {{-- Menggunakan bg-base-content --}}
                            <i class="ease mb-0.75 relative block h-0.5 rounded-sm bg-base-content transition-all"></i>
                            {{-- Menggunakan bg-base-content --}}
                            <i class="ease relative block h-0.5 rounded-sm bg-base-content transition-all"></i>
                            {{-- Menggunakan bg-base-content --}}
                        </div>
                    </a>
                </li>

                <!-- notifications -->
                <li class="relative flex items-center pr-2">
                    <p class="transform-dropdown-show hidden"></p>
                    <a href="javascript:;" class="ease-nav-brand block p-0 text-sm text-base-content transition-all"
                        dropdown-trigger aria-expanded="false"> {{-- Menggunakan text-base-content --}}
                        <i class="ri-notification-3-fill cursor-pointer"></i>
                    </a>

                    <ul dropdown-menu
                        class="transform-dropdown before:font-awesome before:leading-default before:duration-350 before:ease lg:shadow-3xl duration-250 min-w-44 before:text-5.5 pointer-events-none absolute right-0 top-0 z-50 origin-top list-none rounded-lg border-0 border-solid bg-base-100 bg-clip-padding px-2 py-4 text-left text-sm text-base-content opacity-0 transition-all before:absolute before:left-auto before:right-2 before:top-0 before:z-50 before:inline-block before:font-normal before:antialiased before:transition-all before:content-['\f0d8'] sm:-mr-6 before:sm:right-8 lg:absolute lg:left-auto lg:right-0 lg:mt-2 lg:block lg:cursor-pointer">
                        {{-- Menyesuaikan dengan Daisy UI --}}
                        <!-- add show class on dropdown open js -->
                        <li class="relative mb-2">
                            <a class="ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg bg-transparent px-4 duration-300 hover:bg-base-200 hover:text-base-content lg:transition-colors"
                                href="javascript:;"> {{-- Menggunakan bg-base-200 --}}
                                <div class="flex py-1">
                                    <div class="my-auto">
                                        <img src="{{ asset('img/team-2.jpg') }}"
                                            class="mr-4 inline-flex h-9 w-9 max-w-none items-center justify-center rounded-xl text-sm text-white" />
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <h6 class="mb-1 text-sm font-normal leading-normal text-base-content"><span
                                                class="font-semibold">New message</span> from Laur</h6>
                                        {{-- Menggunakan text-base-content --}}
                                        <p class="mb-0 text-xs leading-tight text-base-content/80">
                                            {{-- Menggunakan text-base-content --}}
                                            <i class="ri-time-fill mr-1"></i>
                                            13 minutes ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li class="relative mb-2">
                            <a class="ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg px-4 transition-colors duration-300 hover:bg-base-200 hover:text-base-content"
                                href="javascript:;"> {{-- Menggunakan bg-base-200 --}}
                                <div class="flex py-1">
                                    <div class="my-auto">
                                        <img src="{{ asset('img/small-logos/logo-spotify.svg') }}"
                                            class="mr-4 inline-flex h-9 w-9 max-w-none items-center justify-center rounded-xl bg-base-300 text-sm text-white" />
                                        {{-- Menggunakan bg-base-300 --}}
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <h6 class="mb-1 text-sm font-normal leading-normal text-base-content"><span
                                                class="font-semibold">New album</span> by Travis Scott</h6>
                                        {{-- Menggunakan text-base-content --}}
                                        <p class="mb-0 text-xs leading-tight text-base-content/80">
                                            {{-- Menggunakan text-base-content --}}
                                            <i class="ri-time-fill mr-1"></i>
                                            1 day
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>

                        <li class="relative">
                            <a class="ease py-1.2 clear-both block w-full whitespace-nowrap rounded-lg px-4 transition-colors duration-300 hover:bg-base-200 hover:text-base-content"
                                href="javascript:;"> {{-- Menggunakan bg-base-200 --}}
                                <div class="flex py-1">
                                    <div
                                        class="ease-nav-brand my-auto mr-4 inline-flex h-9 w-9 items-center justify-center rounded-xl bg-base-300 text-sm text-white transition-all duration-200">
                                        {{-- Menggunakan bg-base-300 --}}
                                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <title>credit-card</title>
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF"
                                                    fill-rule="nonzero">
                                                    <g transform="translate(1716.000000, 291.000000)">
                                                        <g transform="translate(453.000000, 454.000000)">
                                                            <path class="color-background"
                                                                d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z"
                                                                opacity="0.593633743"></path>
                                                            <path class="color-background"
                                                                d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z">
                                                            </path>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="flex flex-col justify-center">
                                        <h6 class="mb-1 text-sm font-normal leading-normal text-base-content">Payment
                                            successfully
                                            completed</h6> {{-- Menggunakan text-base-content --}}
                                        <p class="mb-0 text-xs leading-tight text-base-content/80">
                                            {{-- Menggunakan text-base-content --}}
                                            <i class="ri-time-fill mr-1"></i>
                                            2 days
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
