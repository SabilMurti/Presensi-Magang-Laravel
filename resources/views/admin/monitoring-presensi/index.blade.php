<x-app-layout>
    <x-slot name="header">
        <div class="navbar bg-base-100 shadow-sm rounded-box p-4 mb-5">
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-base-content">
                    {{ __('Monitoring Presensi') }}
                </h2>
            </div>
            {{-- <div class="flex-none gap-2">
                <div class="form-control">
                    <input type="text" placeholder="Search" class="input input-bordered w-24 md:w-auto" />
                </div>
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full">
                            <img alt="Tailwind CSS Navbar component" src="https://daisyui.com/images/stock/photo-1534528736684-fd7be0f09929.jpg" />
                        </div>
                    </div>
                    <ul tabindex="0" class="mt-3 z-[1] p-2 shadow menu menu-sm dropdown-content bg-base-100 rounded-box w-52">
                        <li>
                            <a class="justify-between">
                                Profile
                                <span class="badge">New</span>
                            </a>
                        </li>
                        <li><a>Settings</a></li>
                        <li><a>Logout</a></li>
                    </ul>
                </div>
            </div> --}}
        </div>
    </x-slot>

    <div class="container mx-auto px-4 md:px-8 py-6">
        {{-- Statistik Presensi Harian --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="card bg-base-100 shadow-xl p-4">
                <div class="flex items-center space-x-3">
                    <div class="avatar placeholder">
                        <div class="bg-success text-success-content rounded-full w-12 h-12 flex items-center justify-center">
                            <i class="ri-check-line text-2xl"></i>
                        </div>
                    </div>
                    <div>
                        <div class="font-bold text-base-content">Sudah Presensi Masuk</div>
                        <div class="text-xl text-base-content">{{ $summary['total_hadir_masuk'] }}</div>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 shadow-xl p-4">
                <div class="flex items-center space-x-3">
                    <div class="avatar placeholder">
                        <div class="bg-warning text-warning-content rounded-full w-12 h-12 flex items-center justify-center">
                            <i class="ri-time-line text-2xl"></i>
                        </div>
                    </div>
                    <div>
                        <div class="font-bold text-base-content">Belum Presensi Masuk</div>
                        <div class="text-xl text-base-content">{{ $summary['total_belum_masuk'] }}</div>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 shadow-xl p-4">
                <div class="flex items-center space-x-3">
                    <div class="avatar placeholder">
                        <div class="bg-info text-info-content rounded-full w-12 h-12 flex items-center justify-center">
                            <i class="ri-logout-box-r-line text-2xl"></i>
                        </div>
                    </div>
                    <div>
                        <div class="font-bold text-base-content">Sudah Presensi Keluar</div>
                        <div class="text-xl text-base-content">{{ $summary['total_hadir_keluar'] }}</div>
                    </div>
                </div>
            </div>
            <div class="card bg-base-100 shadow-xl p-4">
                <div class="flex items-center space-x-3">
                    <div class="avatar placeholder">
                        <div class="bg-error text-error-content rounded-full w-12 h-12 flex items-center justify-center">
                            <i class="ri-close-line text-2xl"></i>
                        </div>
                    </div>
                    <div>
                        <div class="font-bold text-base-content">Belum Presensi Keluar</div>
                        <div class="text-xl text-base-content">{{ $summary['total_belum_keluar'] }}</div>
                    </div>
                </div>
            </div>
        </div>


        <div class="card bg-base-100 shadow-xl mb-6">
            <div class="card-body">
                <h3 class="card-title text-xl font-semibold text-base-content mb-4">Cari & Filter Presensi</h3>
                <form action="{{ route('admin.monitoring-presensi') }}" method="get" enctype="multipart/form-data">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                        <label class="form-control w-full">
                            <span class="label">
                                <span class="label-text">Tanggal Presensi</span>
                            </span>
                            <input type="date" name="tanggal_presensi" class="input input-bordered w-full"
                                value="{{ request()->tanggal_presensi ? request()->tanggal_presensi : Carbon\Carbon::now()->format('Y-m-d') }}" />
                        </label>

                        <label class="form-control w-full">
                            <span class="label">
                                <span class="label-text">Departemen</span>
                            </span>
                            <select name="departemen_id" class="select select-bordered w-full">
                                <option value="">Semua Departemen</option>
                                @foreach ($departemen as $dept)
                                    <option value="{{ $dept->id }}" {{ request()->departemen_id == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </label>

                        <label class="form-control w-full">
                            <span class="label">
                                <span class="label-text">Status Presensi</span>
                            </span>
                            <select name="status_presensi" class="select select-bordered w-full">
                                <option value="">Semua Status</option>
                                <option value="terlambat" {{ request()->status_presensi == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                                <option value="tepat_waktu" {{ request()->status_presensi == 'tepat_waktu' ? 'selected' : '' }}>Tepat Waktu</option>
                                <option value="belum_masuk" {{ request()->status_presensi == 'belum_masuk' ? 'selected' : '' }}>Belum Presensi Masuk</option>
                                <option value="belum_keluar" {{ request()->status_presensi == 'belum_keluar' ? 'selected' : '' }}>Belum Presensi Keluar</option>
                            </select>
                        </label>

                        <label class="form-control w-full">
                            <span class="label">
                                <span class="label-text">Cari NIK/Nama Karyawan</span>
                            </span>
                            <input type="text" name="search" placeholder="NIK atau Nama Karyawan" class="input input-bordered w-full" value="{{ request()->search }}" />
                        </label>
                    </div>

                    <div class="flex flex-col md:flex-row gap-4 mt-6">
                        <button type="submit" class="btn btn-primary w-full md:w-auto">
                            <i class="ri-search-2-line text-lg"></i>
                            <span class="hidden md:inline">Cari & Filter</span>
                        </button>
                        <a href="{{ route('admin.monitoring-presensi') }}" class="btn btn-secondary w-full md:w-auto">
                            <i class="ri-refresh-line text-lg"></i>
                            <span class="hidden md:inline">Reset Filter</span>
                        </a>
                       
                        <button type="button" class="btn btn-info w-full md:w-auto" onclick="exportData('excel')">
                            <i class="ri-file-excel-line text-lg"></i>
                            <span class="hidden md:inline">Export Excel</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card bg-base-100 shadow-xl">
            <div class="card-body p-0"> {{-- p-0 agar table tidak memiliki padding dobel --}}
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full text-base-content">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>NIK</th>
                                <th>Nama Karyawan</th>
                                <th>Departemen</th>
                                <th>Jam Masuk</th>
                                <th>Foto & Lokasi Masuk</th>
                                <th>Jam Keluar</th>
                                <th>Foto & Lokasi Keluar</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($monitoring as $value => $item)
                                <tr class="hover">
                                    <td class="font-bold">{{ $monitoring->firstItem() + $value }}</td>
                                    <td>{{ $item->nik }}</td>
                                    <td>{{ $item->nama_karyawan }}</td>
                                    <td>{{ $item->nama_departemen }}</td>
                                    <td>{{ $item->jam_masuk }}</td>
                                    <td>
                                        @if ($item->foto_masuk)
                                            <label for="view_modal" class="btn btn-ghost btn-xs tooltip"
                                                data-tip="Lihat Lokasi Masuk"
                                                onclick="return viewLokasi('Lokasi Masuk', '{{ $item->nik }}', '{{ $item->tanggal_presensi }}')">
                                                <div class="avatar">
                                                    <div
                                                        class="w-12 h-12 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                                                        <img src="{{ asset("storage/unggah/presensi/$item->foto_masuk") }}"
                                                            alt="Foto Masuk" />
                                                    </div>
                                                </div>
                                                <i class="ri-map-pin-line ml-2"></i>
                                            </label>
                                        @else
                                            <div class="badge badge-warning gap-2">
                                                <i class="ri-time-line"></i>
                                                Belum Masuk
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->jam_keluar)
                                            {{ $item->jam_keluar }}
                                        @else
                                            <div class="badge badge-warning gap-2">
                                                <i class="ri-time-line"></i>
                                                Belum Presensi
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($item->foto_keluar)
                                            <label for="view_modal" class="btn btn-ghost btn-xs tooltip"
                                                data-tip="Lihat Lokasi Keluar"
                                                onclick="return viewLokasi('Lokasi Keluar', '{{ $item->nik }}', '{{ $item->tanggal_presensi }}')">
                                                <div class="avatar">
                                                    <div class="w-12 h-12 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                                                        <img src="{{ asset("storage/unggah/presensi/$item->foto_keluar") }}" alt="Foto Keluar" />
                                                    </div>
                                                </div>
                                                <i class="ri-map-pin-line ml-2"></i>
                                            </label>
                                        @else
                                            <span class="text-gray-400">Tidak Ada</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (!$item->jam_masuk)
                                            <div class="badge badge-error gap-2">
                                                <i class="ri-close-line"></i>
                                                Tidak Masuk
                                            </div>
                                        @elseif ($item->jam_masuk > Carbon\Carbon::make('08:00:00')->format('H:i:s'))
                                            @php
                                                $masuk = Carbon\Carbon::make($item->jam_masuk);
                                                $batas = Carbon\Carbon::make('08:00:00');
                                                $diff = $masuk->diff($batas);
                                                if ($diff->format('%h') != 0) {
                                                    $selisih = $diff->format('%h jam %I menit');
                                                } else {
                                                    $selisih = $diff->format('%I menit');
                                                }
                                            @endphp
                                            <div class="badge badge-error gap-2 tooltip"
                                                data-tip="Terlambat {{ $selisih }}">
                                                <i class="ri-alarm-line"></i>
                                                Terlambat
                                            </div>
                                        @else
                                            <div class="badge badge-success gap-2">
                                                <i class="ri-check-line"></i>
                                                Tepat Waktu
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-4 text-base-content">Tidak ada data
                                        presensi untuk tanggal ini dengan filter yang dipilih.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 pagination"> {{-- Pastikan ada kelas pagination di sini --}}
                    {{ $monitoring->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Awal Modal View Lokasi --}}
    <input type="checkbox" id="view_modal" class="modal-toggle" />
    <div class="modal" role="dialog">
        <div class="modal-box w-11/12 max-w-2xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="judul-lokasi text-2xl font-bold text-base-content"></h3>
                <label for="view_modal" class="btn btn-sm btn-circle btn-ghost">
                    <i class="ri-close-line text-xl"></i>
                </label>
            </div>
            <div>
                <label class="form-control w-full">
                    <div class="label">
                        <span class="label-text font-semibold text-base-content">
                            Koordinat
                            <span class="label-text-alt" id="loading_edit1"></span>
                        </span>
                    </div>
                    <input type="text" name="lokasi" placeholder="Lokasi"
                        class="input input-bordered w-full text-info font-mono" readonly />
                    <div id="lokasi-map" class="mx-auto mt-4 h-80 w-full rounded-lg shadow-md bg-base-200"></div>
                </label>
            </div>
        </div>
        <label class="modal-backdrop" for="view_modal">Close</label>
    </div>
    {{-- Akhir Modal View Lokasi --}}

    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoMdULhJDt+yHKLfmMFAKRNBvKg/fSIADNEqaT4=" crossorigin="" />
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjGwZZxSNmC+ooxsS+skfVso0Q4nQ+" crossorigin=""></script>
        <script>
            // Pastikan SweetAlert2 sudah terintegrasi
            @if (session()->has('success'))
                Swal.fire({
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    confirmButtonColor: 'oklch(var(--p))', // Menggunakan warna primary DaisyUI
                    confirmButtonText: 'OK',
                });
            @endif

            @if (session()->has('error'))
                Swal.fire({
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    confirmButtonColor: 'oklch(var(--er))', // Menggunakan warna error DaisyUI
                    confirmButtonText: 'OK',
                });
            @endif

            let currentMap = null; // Variabel untuk menyimpan instance peta saat ini

            function maps(latitude, longitude) {
                // Hancurkan instance peta yang ada sebelum membuat yang baru
                if (currentMap) {
                    currentMap.remove();
                }

                currentMap = L.map('lokasi-map').setView([latitude, longitude], 17);
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(currentMap);

                let marker = L.marker([latitude, longitude]).addTo(currentMap);
                marker.bindPopup("<b>Lokasi Presensi</b>").openPopup();

                let circle = L.circle([{{ $lokasiKantor->latitude }}, {{ $lokasiKantor->longitude }}], {
                    color: 'oklch(var(--er))', // Menggunakan warna error DaisyUI
                    fillColor: 'oklch(var(--er) / 0.5)',
                    fillOpacity: 0.5,
                    radius: {{ $lokasiKantor->radius }}
                }).addTo(currentMap);

                // Menambahkan popup untuk lokasi kantor
                circle.bindPopup("Radius Lokasi Kantor: {{ $lokasiKantor->radius }} meter");

                // Memastikan peta di-render ulang setelah modal terbuka
                setTimeout(() => {
                    currentMap.invalidateSize();
                }, 100); // Sedikit delay
            }

            function viewLokasi(tipe, nik, tanggal) {
                // Reset modal content
                $(".judul-lokasi").html("");
                $("input[name='lokasi']").val("");
                $("#lokasi-map").empty();

                // Loading effect start
                let loading = `<span class="loading loading-spinner loading-sm text-primary"></span>`;
                $("#loading_edit1").html(loading);

                $.ajax({
                    type: "post",
                    url: "{{ route('admin.monitoring-presensi.lokasi') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "tipe": tipe,
                        "nik": nik,
                        "tanggal_presensi": tanggal
                    },
                    success: function(response) {
                        console.log("Response:", response); // Debug

                        $(".judul-lokasi").html(tipe + " - NIK: " + nik);

                        let lokasiString = response.lokasi;
                        $("input[name='lokasi']").val(lokasiString);

                        // Loading effect end
                        $("#loading_edit1").html("");

                        if (lokasiString && lokasiString.includes(",")) {
                            let coords = lokasiString.split(",");
                            let lat = parseFloat(coords[0].trim());
                            let lng = parseFloat(coords[1].trim());

                            if (!isNaN(lat) && !isNaN(lng)) {
                                maps(lat, lng);
                            } else {
                                $("#lokasi-map").html('<div class="text-center text-error mt-4">Format koordinat tidak valid.</div>');
                            }
                        } else {
                            $("#lokasi-map").html('<div class="text-center text-error mt-4">Data lokasi tidak tersedia atau format salah.</div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        $("#loading_edit1").html('');
                        $(".judul-lokasi").html(tipe + " - Error");
                        $("input[name='lokasi']").val("Gagal memuat koordinat.");
                        $("#lokasi-map").html('<div class="text-center text-error mt-4">Terjadi kesalahan: ' + error + '</div>');
                        console.error("AJAX Error:", xhr.responseText);
                    }
                });
            }

            function exportData(format) {
                const tanggalPresensi = $('input[name="tanggal_presensi"]').val();
                const departemenId = $('select[name="departemen_id"]').val();
                const statusPresensi = $('select[name="status_presensi"]').val();
                const search = $('input[name="search"]').val();

                let url = `{{ route('admin.monitoring-presensi.export', ['format' => ':format']) }}`;
                url = url.replace(':format', format);

                const params = new URLSearchParams();
                if (tanggalPresensi) params.append('tanggal_presensi', tanggalPresensi);
                if (departemenId) params.append('departemen_id', departemenId);
                if (statusPresensi) params.append('status_presensi', statusPresensi);
                if (search) params.append('search', search);

                window.location.href = `${url}?${params.toString()}`;
            }
        </script>
    @endpush
</x-app-layout>