<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold leading-tight text-base-content">
            {{ __("Dashboard") }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
            {{-- Card Total Karyawan --}}
            <div class="card bg-base-100 shadow-lg border border-base-200 hover:shadow-xl transition-shadow duration-300">
                <div class="card-body flex-row items-center p-4">
                    <div class="bg-primary-focus text-primary-content p-3 rounded-full flex-shrink-0">
                        <i class="ri-team-line text-3xl"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="card-title text-3xl font-bold text-base-content">{{ $totalKaryawan }}</h2>
                        <p class="text-base-content text-opacity-70 text-lg">Total Karyawan</p>
                    </div>
                </div>
            </div>

            {{-- Card Karyawan Hadir --}}
            <div class="card bg-base-100 shadow-lg border border-base-200 hover:shadow-xl transition-shadow duration-300">
                <div class="card-body flex-row items-center p-4">
                    <div class="bg-success-focus text-success-content p-3 rounded-full flex-shrink-0">
                        <i class="ri-fingerprint-fill text-3xl"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="card-title text-3xl font-bold text-base-content">{{ $rekapPresensi->jml_kehadiran ?? 0 }}</h2>
                        <p class="text-base-content text-opacity-70 text-lg">Karyawan Hadir</p>
                    </div>
                </div>
            </div>

            {{-- Card Karyawan Sakit --}}
            <div class="card bg-base-100 shadow-lg border border-base-200 hover:shadow-xl transition-shadow duration-300">
                <div class="card-body flex-row items-center p-4">
                    <div class="bg-warning-focus text-warning-content p-3 rounded-full flex-shrink-0">
                        <i class="ri-hospital-line text-3xl"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="card-title text-3xl font-bold text-base-content">{{ $rekapPengajuanPresensi->jml_sakit ?? 0 }}</h2>
                        <p class="text-base-content text-opacity-70 text-lg">Karyawan Sakit</p>
                    </div>
                </div>
            </div>

            {{-- Card Karyawan Izin --}}
            <div class="card bg-base-100 shadow-lg border border-base-200 hover:shadow-xl transition-shadow duration-300">
                <div class="card-body flex-row items-center p-4">
                    <div class="bg-info-focus text-info-content p-3 rounded-full flex-shrink-0">
                        <i class="ri-file-list-line text-3xl"></i> {{-- Mengganti ikon untuk Izin --}}
                    </div>
                    <div class="ml-4">
                        <h2 class="card-title text-3xl font-bold text-base-content">{{ $rekapPengajuanPresensi->jml_izin ?? 0 }}</h2>
                        <p class="text-base-content text-opacity-70 text-lg">Karyawan Izin</p>
                    </div>
                </div>
            </div>

            {{-- Card Karyawan Terlambat --}}
            <div class="card bg-base-100 shadow-lg border border-base-200 hover:shadow-xl transition-shadow duration-300">
                <div class="card-body flex-row items-center p-4">
                    <div class="bg-error-focus text-error-content p-3 rounded-full flex-shrink-0">
                        <i class="ri-time-line text-3xl"></i>
                    </div>
                    <div class="ml-4">
                        <h2 class="card-title text-3xl font-bold text-base-content">{{ $rekapPresensi->jml_terlambat ?? 0 }}</h2>
                        <p class="text-base-content text-opacity-70 text-lg">Karyawan Terlambat</p>
                    </div>
                </div>
            </div>
        </div>
    </div>


</x-app-layout>