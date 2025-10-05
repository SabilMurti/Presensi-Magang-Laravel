@extends('dashboard.layouts.main')

@section('container')
    <div class="container mx-auto p-4 sm:p-6 lg:p-8"> {{-- Container utama dengan padding responsif --}}
        <!-- row 1: Ringkasan Presensi -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8"> {{-- Grid responsif untuk kartu ringkasan --}}
            <!-- Jam Masuk Kerja -->
            <div
                class="card bg-base-100 shadow-xl border border-base-200 rounded-box transition-all duration-300 hover:shadow-2xl">
                <div class="card-body p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold uppercase text-base-content opacity-70 mb-1">Jam Masuk Kerja</p>
                            <h5 class="text-2xl font-bold text-base-content">08:00 WIB</h5>
                        </div>
                        <div
                            class="avatar placeholder bg-gradient-to-tl from-primary to-accent text-white rounded-full p-2 shadow-lg">
                            {{-- Menggunakan kelas warna DaisyUI --}}
                            <div class="w-12 h-12 flex items-center justify-center">
                                <i class="ri-time-line text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jam Pulang Kerja -->
            <div
                class="card bg-base-100 shadow-xl border border-base-200 rounded-box transition-all duration-300 hover:shadow-2xl">
                <div class="card-body p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold uppercase text-base-content opacity-70 mb-1">Jam Pulang Kerja
                            </p>
                            <h5 class="text-2xl font-bold text-base-content">16:00 WIB</h5>
                        </div>
                        <div
                            class="avatar placeholder bg-gradient-to-tl from-error to-warning text-white rounded-full p-2 shadow-lg">
                            {{-- Menggunakan kelas warna DaisyUI --}}
                            <div class="w-12 h-12 flex items-center justify-center">
                                <i class="ri-time-line text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Masuk Kerja Hari Ini -->
            <div
                class="card bg-base-100 shadow-xl border border-base-200 rounded-box transition-all duration-300 hover:shadow-2xl">
                <div class="card-body p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold uppercase text-base-content opacity-70 mb-1">Masuk Kerja Hari
                                Ini</p>
                            <h5 class="text-2xl font-bold text-base-content">
                                {{ $presensiHariIni != null ? date('H:i:s', strtotime($presensiHariIni->jam_masuk)) . ' WIB' : 'Belum Presensi' }}
                            </h5>
                            @if ($presensiHariIni != null)
                                @if (date('H:i:s', strtotime($presensiHariIni->jam_masuk)) < date_create('08:00:00')->format('H:i:s'))
                                    <span class="text-sm font-bold text-success">Anda Datang Lebih Awal</span>
                                @elseif (date('H:i:s', strtotime($presensiHariIni->jam_masuk)) > date_create('08:00:00')->format('H:i:s'))
                                    <span class="text-sm font-bold text-error">Anda Datang Terlambat</span>
                                @else
                                    <span class="text-sm font-bold text-info">Tepat Waktu</span>
                                @endif
                            @endif
                        </div>
                        <div
                            class="avatar placeholder bg-gradient-to-tl from-success to-info text-white rounded-full p-2 shadow-lg">
                            <div class="w-12 h-12 flex items-center justify-center">
                                <i class="ri-login-circle-line text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pulang Kerja Hari Ini -->
            <div
                class="card bg-base-100 shadow-xl border border-base-200 rounded-box transition-all duration-300 hover:shadow-2xl">
                <div class="card-body p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold uppercase text-base-content opacity-70 mb-1">Pulang Kerja Hari
                                Ini</p>
                            <h5 class="text-2xl font-bold text-base-content">
                                {{ $presensiHariIni != null && $presensiHariIni->jam_keluar != null ? date('H:i:s', strtotime($presensiHariIni->jam_keluar)) . ' WIB' : 'Belum Presensi' }}
                            </h5>
                            @if ($presensiHariIni != null && $presensiHariIni->jam_keluar != null)
                                @if (date('H:i:s', strtotime($presensiHariIni->jam_keluar)) < date_create('16:00:00')->format('H:i:s'))
                                    <span class="text-sm font-bold text-error">Anda Pulang Lebih Awal</span>
                                @elseif (date('H:i:s', strtotime($presensiHariIni->jam_keluar)) > date_create('16:00:00')->format('H:i:s'))
                                    <span class="text-sm font-bold text-success">Anda Pulang Lebih Lama</span>
                                @else
                                    <span class="text-sm font-bold text-info">Tepat Waktu</span>
                                @endif
                            @endif
                        </div>
                        <div
                            class="avatar placeholder bg-gradient-to-tl from-warning to-accent text-white rounded-full p-2 shadow-lg">
                            <div class="w-12 h-12 flex items-center justify-center">
                                <i class="ri-logout-circle-line text-2xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- PRESENSI SEKARANG BUTTON, karyawan.presensi  --}}
        <div class="flex justify-center mt-8 card bg-base-100 shadow-xl border border-base-200 rounded-box p-6">

            @if ($presensiHariIni == null)
                <a href="{{ route('karyawan.presensi') }}"
                    class="btn btn-primary btn-lg rounded-full shadow-lg hover:shadow-xl transition-all duration-200">
                    <i class="ri-login-circle-line mr-2"></i>
                    Presensi Masuk
                </a>
            @elseif($presensiHariIni != null && $presensiHariIni->jam_keluar == null)
                <a href="{{ route('karyawan.presensi') }}"
                    class="btn btn-success btn-lg rounded-full shadow-lg hover:shadow-xl transition-all duration-200">
                    <i class="ri-logout-circle-line mr-2"></i>
                    Presensi Keluar
                </a>
            @else
                <button disabled
                    class="btn btn-disabled btn-lg rounded-full shadow-lg transition-all duration-200 cursor-not-allowed">
                    <i class="ri-checkbox-circle-line mr-2"></i>
                    Anda Sudah Presensi Hari Ini
                </button>
            @endif

        <!-- row 2: Rekap Presensi & Leaderboard -->
        <div
            class="card bg-base-100 shadow-xl border border-base-200 rounded-box mt-8 transition-all duration-300 hover:shadow-2xl">
            <div class="card-body p-6 sm:p-8">
                <h2 class="card-title text-base-content text-2xl font-semibold mb-6 opacity-90">Riwayat Presensi Bulan
                    <span class="font-bold text-primary">{{ date('F') }}</span>
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8"> {{-- Grid untuk rekap kehadiran --}}
                    <!-- Rekap Hadir -->
                    <div class="card compact bg-base-200 shadow-md rounded-box transition-all duration-200 hover:shadow-lg">
                        <div class="card-body p-4 flex-row items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase text-base-content opacity-70 mb-1">Hadir</p>
                                <h5 class="text-xl font-bold text-base-content">{{ $rekapPresensi->jml_kehadiran }}</h5>
                            </div>
                            <div
                                class="avatar placeholder bg-gradient-to-tl from-blue-500 to-blue-400 text-white rounded-full p-1 shadow-sm">
                                <div class="w-10 h-10 flex items-center justify-center">
                                    <i class="ri-body-scan-line text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rekap Sakit -->
                    <div class="card compact bg-base-200 shadow-md rounded-box transition-all duration-200 hover:shadow-lg">
                        <div class="card-body p-4 flex-row items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase text-base-content opacity-70 mb-1">Sakit</p>
                                <h5 class="text-xl font-bold text-base-content">{{ $rekapPengajuanPresensi->jml_sakit }}
                                </h5>
                            </div>
                            <div
                                class="avatar placeholder bg-gradient-to-tl from-emerald-500 to-teal-400 text-white rounded-full p-1 shadow-sm">
                                <div class="w-10 h-10 flex items-center justify-center">
                                    <i class="ri-hospital-line text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rekap Izin -->
                    <div class="card compact bg-base-200 shadow-md rounded-box transition-all duration-200 hover:shadow-lg">
                        <div class="card-body p-4 flex-row items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase text-base-content opacity-70 mb-1">Izin</p>
                                <h5 class="text-xl font-bold text-base-content">{{ $rekapPengajuanPresensi->jml_izin }}
                                </h5>
                            </div>
                            <div
                                class="avatar placeholder bg-gradient-to-tl from-yellow-500 to-amber-400 text-white rounded-full p-1 shadow-sm">
                                <div class="w-10 h-10 flex items-center justify-center">
                                    <i class="ri-file-list-3-line text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rekap Terlambat -->
                    <div class="card compact bg-base-200 shadow-md rounded-box transition-all duration-200 hover:shadow-lg">
                        <div class="card-body p-4 flex-row items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase text-base-content opacity-70 mb-1">Terlambat
                                </p>
                                <h5 class="text-xl font-bold text-base-content">
                                    {{ $rekapPresensi->jml_terlambat ? $rekapPresensi->jml_terlambat : 0 }}</h5>
                            </div>
                            <div
                                class="avatar placeholder bg-gradient-to-tl from-red-600 to-orange-500 text-white rounded-full p-1 shadow-sm">
                                <div class="w-10 h-10 flex items-center justify-center">
                                    <i class="ri-timer-2-line text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8 mt-6">
                    {{-- Tabel Rekap Presensi --}}
                    <div class="overflow-x-auto rounded-lg shadow-md border border-base-200"> {{-- Bungkus tabel dengan div untuk styling border dan shadow --}}
                        <h3
                            class="p-4 text-lg font-semibold text-base-content opacity-90 border-b border-base-200 bg-base-200 rounded-t-lg">
                            Rekap Presensi</h3>
                        <table class="table w-full">
                            {{-- head --}}
                            <thead>
                                <tr class="bg-base-200 text-base-content opacity-80">
                                    <th></th>
                                    <th>Hari</th>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Keluar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($riwayatPresensi as $value => $item)
                                    <tr class="hover:bg-base-200">
                                        <td class="font-bold text-base-content">
                                            {{ $riwayatPresensi->firstItem() + $value }}</td>
                                        <td class="text-base-content opacity-80">
                                            {{ date('l', strtotime($item->tanggal_presensi)) }}</td>
                                        <td class="text-base-content opacity-80">
                                            {{ date('d-m-Y', strtotime($item->tanggal_presensi)) }}</td>
                                        <td
                                            class="{{ $item->jam_masuk < '08:00' ? 'text-success' : 'text-error' }} font-semibold">
                                            {{ date('H:i:s', strtotime($item->jam_masuk)) }}
                                        </td>
                                        @if ($item != null && $item->jam_keluar != null)
                                            <td
                                                class="{{ $item->jam_keluar > '16:00' ? 'text-success' : 'text-error' }} font-semibold">
                                                {{ date('H:i:s', strtotime($item->jam_keluar)) }}
                                            </td>
                                        @else
                                            <td class="text-base-content opacity-70 italic">Belum Presensi</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="p-4 border-t border-base-200 bg-base-200 rounded-b-lg flex justify-center">
                            {{ $riwayatPresensi->links('pagination::tailwind') }} {{-- Memastikan pagination menggunakan gaya Tailwind/DaisyUI --}}
                        </div>
                    </div>

                    {{-- Tabel Leaderboard Hari ini --}}
                    <div class="overflow-x-auto rounded-lg shadow-md border border-base-200"> {{-- Bungkus tabel dengan div untuk styling border dan shadow --}}
                        <h3
                            class="p-4 text-lg font-semibold text-base-content opacity-90 border-b border-base-200 bg-base-200 rounded-t-lg">
                            Leaderboard <span class="font-bold text-primary">{{ date('d-m-Y') }}</span>
                        </h3>
                        <table class="table w-full">
                            {{-- head --}}
                            <thead>
                                <tr class="bg-base-200 text-base-content opacity-80">
                                    <th></th>
                                    <th>Nama</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Keluar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($leaderboard as $value => $item)
                                    <tr class="hover:bg-base-200">
                                        <td class="font-bold text-base-content">
                                            {{ $leaderboard->firstItem() + $value }}</td>
                                        <td>
                                            <div class="flex items-center space-x-3">
                                                {{-- Anda bisa menambahkan avatar di sini jika ada gambar profil --}}
                                                {{-- <div class="avatar">
                                                    <div class="mask mask-squircle w-10 h-10">
                                                        <img src="/tailwind-css-component-profile-2@56w.png" alt="Avatar Tailwind CSS Component" />
                                                    </div>
                                                </div> --}}
                                                <div>
                                                    <div class="font-bold text-base-content">{{ $item->nama_lengkap }}
                                                    </div>
                                                    <div class="text-sm opacity-70 text-base-content">
                                                        {{ $item->jabatan }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td
                                            class="{{ $item->jam_masuk < '08:00' ? 'text-success' : 'text-error' }} font-semibold">
                                            {{ date('H:i:s', strtotime($item->jam_masuk)) }}
                                        </td>
                                        @if ($item != null && $item->jam_keluar != null)
                                            <td
                                                class="{{ $item->jam_keluar > '16:00' ? 'text-success' : 'text-error' }} font-semibold">
                                                {{ date('H:i:s', strtotime($item->jam_keluar)) }}
                                            </td>
                                        @else
                                            <td class="text-base-content opacity-70 italic">Belum Presensi</td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="p-4 border-t border-base-200 bg-base-200 rounded-b-lg flex justify-center">
                            {{ $leaderboard->links('pagination::tailwind') }} {{-- Memastikan pagination menggunakan gaya Tailwind/DaisyUI --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
