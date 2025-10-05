<x-app-layout>
    <x-slot name="header">
        <div class="navbar bg-base-100 shadow-sm rounded-box p-4 mb-5">
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-base-content">
                    {{ __("Laporan Presensi") }}
                </h2>
            </div>
            {{-- Theme switcher sudah ada di app.blade.php --}}
        </div>
    </x-slot>

    <div class="container mx-auto px-4 md:px-8 py-6">
        {{-- Laporan Presensi Karyawan Individu --}}
        <div class="card bg-base-100 shadow-xl mb-8">
            <div class="card-body">
                <h3 class="card-title text-xl font-semibold text-base-content mb-4">Laporan Presensi Karyawan Individu</h3>
                <form action="{{ route("admin.laporan.presensi.karyawan") }}" method="post" target="_blank" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">Pilih Bulan</span>
                            </div>
                            <input type="month" name="bulan" class="input input-bordered w-full" value="{{ Carbon\Carbon::now()->format("Y-m") }}" required />
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text">Pilih Karyawan</span>
                            </div>
                            <select name="karyawan" class="select select-bordered w-full" required>
                                <option disabled selected value="">Pilih karyawan!</option>
                                @foreach ($karyawan as $item)
                                    <option value="{{ $item->nik }}">{{ $item->nama_lengkap }}</option>
                                @endforeach
                            </select>
                        </label>
                        <div class="flex items-end h-full">
                            <button type="submit" class="btn btn-info w-full">
                                <i class="ri-file-pdf-2-fill text-lg"></i>
                                <span class="ml-2">Cetak Laporan</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Laporan Presensi Semua Karyawan --}}
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body">
                <h3 class="card-title text-xl font-semibold text-base-content mb-4">Laporan Presensi Semua Karyawan</h3>
                <form action="{{ route("admin.laporan.presensi.semua-karyawan") }}" method="post" target="_blank" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                        <label class="form-control w-full md:col-span-2">
                            <div class="label">
                                <span class="label-text">Pilih Bulan</span>
                            </div>
                            <input type="month" name="bulan" class="input input-bordered w-full" value="{{ Carbon\Carbon::now()->format("Y-m") }}" required />
                        </label>
                        <div class="flex items-end h-full">
                            <button type="submit" class="btn btn-info w-full">
                                <i class="ri-file-pdf-2-fill text-lg"></i>
                                <span class="ml-2">Cetak Laporan</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>