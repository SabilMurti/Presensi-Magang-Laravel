@extends("dashboard.layouts.main")

@section("js")
    <script>
        $(document).ready(function() {
            $("#searchButton").click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{{ route("karyawan.history.search") }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        bulan: $("#bulan").val(),
                        tahun: $("#tahun").val()
                    },
                    cache: false,
                    success: function(res) {
                        $("#searchPresensi").html(res);
                        // Perhatikan: Jika response AJAX berisi HTML pagination,
                        // pastikan styling pagination default Laravel Anda sudah diterapkan pada elemen baru.
                        // Jika tidak, mungkin perlu inisialisasi ulang script/styling khusus jika ada.
                    }
                });
            });
        });
    </script>
@endsection

@section("container")
    <div class="p-4 sm:p-6 lg:p-8">
        {{-- Card utama yang modern dan lembut --}}
        <div class="card bg-base-100 shadow-2xl rounded-2xl border border-base-200">
            <div class="card-body">
                <h2 class="card-title text-3xl font-extrabold mb-6 text-base-content text-center lg:text-left">Riwayat Presensi</h2>

                {{-- Input Filter --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8 items-end">
                    <div>
                        <label for="bulan" class="label">
                            <span class="label-text text-base-content text-lg font-medium">Bulan</span>
                        </label>
                        <select name="bulan" id="bulan" class="select select-bordered select-md w-full text-base-content focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                            <option disabled selected>Pilih Bulan!</option>
                            @foreach ($bulan as $value => $item)
                                <option value="{{ $value + 1 }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="tahun" class="label">
                            <span class="label-text text-base-content text-lg font-medium">Tahun</span>
                        </label>
                        <select name="tahun" id="tahun" class="select select-bordered select-md w-full text-base-content focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" required>
                            <option disabled selected>Pilih Tahun!</option>
                            @php
                                $tahunMulai = $riwayatPresensi->first() ? date("Y", strtotime($riwayatPresensi->first()->tanggal_presensi)) : date("Y");
                            @endphp
                            @for ($tahun = $tahunMulai; $tahun <= date("Y"); $tahun++)
                                <option value="{{ $tahun }}">{{ $tahun }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-span-1 md:col-span-2 lg:col-span-1 flex justify-center md:justify-start lg:justify-end">
                        <button type="button" id="searchButton" class="btn btn-primary btn-md w-full max-w-xs transition-all duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">Cari</button>
                    </div>
                </div>

                {{-- Tabel Riwayat Presensi --}}
                <div id="searchPresensi" class="overflow-x-auto rounded-lg shadow-inner">
                    <table id="tabelPresensi" class="table table-zebra w-full text-base-content">
                        <thead>
                            <tr class="bg-base-200 text-base-content uppercase tracking-wider">
                                <th class="py-3 px-4 text-left">No</th>
                                <th class="py-3 px-4 text-left">Hari</th>
                                <th class="py-3 px-4 text-left">Tanggal</th>
                                <th class="py-3 px-4 text-left">Jam Masuk</th>
                                <th class="py-3 px-4 text-left">Jam Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($riwayatPresensi as $value => $item)
                                <tr class="hover:bg-base-200/50">
                                    <td class="font-medium text-base-content py-3 px-4">{{ $riwayatPresensi->firstItem() + $value }}</td>
                                    <td class="text-base-content py-3 px-4">{{ date("l", strtotime($item->tanggal_presensi)) }}</td>
                                    <td class="text-base-content py-3 px-4">{{ date("d-m-Y", strtotime($item->tanggal_presensi)) }}</td>
                                    <td class="{{ $item->jam_masuk < "08:00" ? "text-success" : "text-error" }} font-semibold py-3 px-4">{{ date("H:i:s", strtotime($item->jam_masuk)) }}</td>
                                    @if ($item && $item->jam_keluar)
                                        <td class="{{ $item->jam_keluar > "16:00" ? "text-success" : "text-error" }} font-semibold py-3 px-4">{{ date("H:i:s", strtotime($item->jam_keluar)) }}</td>
                                    @else
                                        <td class="text-warning font-semibold py-3 px-4">Belum Presensi</td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-8 text-lg text-info-content">Tidak ada data riwayat presensi yang ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination default Laravel dengan kelas khusus --}}
                <div class="p-4 ">
                    {{ $riwayatPresensi->links() }}
                </div>

            </div> {{-- End card-body --}}
        </div> {{-- End card --}}
    </div> {{-- End padding div --}}
@endsection