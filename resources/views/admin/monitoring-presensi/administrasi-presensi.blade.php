<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-base-content">
                {{ __("Administrasi Presensi") }}
            </h2>
        </div>
    </x-slot>

    <div class="container mx-auto px-5 pt-5">
        <div>
            <form action="{{ route("admin.administrasi-presensi") }}" method="get" enctype="multipart/form-data" class="my-3">
                <div class="flex w-full flex-wrap gap-2 md:flex-nowrap items-end">
                    <label class="form-control w-full max-w-xs">
                        <div class="label">
                            <span class="label-text">NIK</span>
                        </div>
                        <input type="text" name="nik" placeholder="NIK" class="input input-bordered w-full" value="{{ request()->nik }}" />
                    </label>
                    <label class="form-control w-full max-w-xs">
                        <div class="label">
                            <span class="label-text">Nama Karyawan</span>
                        </div>
                        <input type="text" name="karyawan" placeholder="Nama Karyawan" class="input input-bordered w-full" value="{{ request()->karyawan }}" />
                    </label>
                    <label class="form-control w-full max-w-xs">
                        <div class="label">
                            <span class="label-text">Departemen</span>
                        </div>
                        <select name="departemen" class="select select-bordered">
                            <option value="0">Semua Departemen</option>
                            @foreach ($departemen as $item)
                                <option value="{{ $item->id }}" {{ request()->departemen == $item->id ? "selected" : "" }}>{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="form-control w-full max-w-xs">
                        <div class="label">
                            <span class="label-text">Tanggal Awal</span>
                        </div>
                        <input type="date" name="tanggal_awal" class="input input-bordered w-full" value="{{ request()->tanggal_awal ? request()->tanggal_awal : \Carbon\Carbon::now()->startOfMonth()->format("Y-m-d") }}" />
                    </label>
                    <label class="form-control w-full max-w-xs">
                        <div class="label">
                            <span class="label-text">Tanggal Akhir</span>
                        </div>
                        <input type="date" name="tanggal_akhir" class="input input-bordered w-full" value="{{ request()->tanggal_akhir ? request()->tanggal_akhir : \Carbon\Carbon::now()->endOfMonth()->format("Y-m-d") }}" />
                    </label>
                    <label class="form-control w-full max-w-xs">
                        <div class="label">
                            <span class="label-text">Status</span>
                        </div>
                        <select name="status" class="select select-bordered">
                            <option value="0">Semua Status</option>
                            <option value="I" {{ request()->status == 'I' ? "selected" : "" }}>Izin</option>
                            <option value="S" {{ request()->status == 'S' ? "selected" : "" }}>Sakit</option>
                        </select>
                    </label>
                    <label class="form-control w-full max-w-xs">
                        <div class="label">
                            <span class="label-text">Status Approved</span>
                        </div>
                        <select name="status_approved" class="select select-bordered">
                            <option value="0">Semua Aksi</option>
                            <option value="1" {{ request()->status_approved == 1 ? "selected" : "" }}>Pending</option>
                            <option value="2" {{ request()->status_approved == 2 ? "selected" : "" }}>Diterima</option>
                            <option value="3" {{ request()->status_approved == 3 ? "selected" : "" }}>Ditolak</option>
                        </select>
                    </label>
                    <button type="submit" class="btn btn-success w-full md:w-14">
                        <i class="ri-search-2-line text-lg text-white"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="w-full overflow-x-auto rounded-md bg-base-200 px-10">
            <table id="tabelPresensi" class="table mb-4 w-full border-collapse items-center border-base-300 align-top">
                <thead class="text-sm text-base-content">
                    <tr>
                        <th></th>
                        <th>Nama Karyawan / NIK</th>
                        <th>Departemen</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengajuan as $value => $item)
                        <tr class="hover">
                            <td class="font-bold">{{ $value + 1 }}</td>
                            <td class="text-base-content/70">{{ $item->nama_karyawan }} - {{ $item->nik }}</td>
                            <td class="text-base-content/70">{{ $item->nama_departemen }}</td>
                            <td class="text-base-content/70">{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format("l, d-m-Y") }}</td>
                            <td class="text-base-content/70">
                                @if ($item->status == "I")
                                    <span>Izin</span>
                                @elseif ($item->status == "S")
                                    <span>Sakit</span>
                                @endif
                            </td>
                            <td class="text-base-content/70">{{ $item->keterangan }}</td>
                            <td class="flex justify-center gap-2">
                                @if ($item->status_approved == 1)
                                    <label for="modal_terima" class="btn btn-warning btn-sm tooltip flex items-center" data-tip="Diterima" onclick="setModalData('terima', '{{ $item->id }}', '{{ $item->nama_karyawan }}', '{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d-m-Y') }}')">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </label>
                                    <label for="modal_tolak" class="btn btn-error btn-sm tooltip flex items-center" data-tip="Ditolak" onclick="setModalData('tolak', '{{ $item->id }}', '{{ $item->nama_karyawan }}', '{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d-m-Y') }}')">
                                        <i class="ri-close-circle-line"></i>
                                    </label>
                                @elseif ($item->status_approved == 2)
                                    <div class="flex items-center gap-2">
                                        <div class="badge badge-success">Diterima</div>
                                        <label for="modal_batal" class="btn btn-error btn-sm tooltip flex items-center" data-tip="Dibatalkan" onclick="setModalData('batal', '{{ $item->id }}', '{{ $item->nama_karyawan }}', '{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d-m-Y') }}')">
                                            <i class="ri-close-circle-line"></i>
                                        </label>
                                    </div>
                                @elseif ($item->status_approved == 3)
                                    <div class="flex items-center gap-2">
                                        <div class="badge badge-error">Ditolak</div>
                                        <label for="modal_batal" class="btn btn-error btn-sm tooltip flex items-center" data-tip="Dibatalkan" onclick="setModalData('batal', '{{ $item->id }}', '{{ $item->nama_karyawan }}', '{{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->format('d-m-Y') }}')">
                                            <i class="ri-close-circle-line"></i>
                                        </label>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mx-3 mb-5">
                {{ $pengajuan->links() }}
            </div>
        </div>
    </div>

    <!-- Modal Success/Error -->
    <input type="checkbox" id="modal_notification" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg" id="notification_title"></h3>
            <p class="py-4" id="notification_message"></p>
            <div class="modal-action">
                <label for="modal_notification" class="btn btn-primary" onclick="handleNotificationClose()">OK</label>
            </div>
        </div>
    </div>

    <!-- Modal Terima -->
    <input type="checkbox" id="modal_terima" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Pengajuan Presensi Diterima</h3>
            <p class="py-4">Apakah Anda menerima pengajuan presensi?</p>
            <div class="divider"></div>
            <div class="flex flex-col gap-2">
                <p><strong>Karyawan:</strong> <span id="terima_karyawan"></span></p>
                <p><strong>Tanggal Pengajuan:</strong> <span id="terima_tanggal"></span></p>
            </div>
            <div class="modal-action">
                <label for="modal_terima" class="btn btn-ghost">Batal</label>
                <button class="btn btn-primary" onclick="submitAction('terima')">Terima</button>
            </div>
        </div>
    </div>

    <!-- Modal Tolak -->
    <input type="checkbox" id="modal_tolak" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Pengajuan Presensi Ditolak</h3>
            <p class="py-4">Apakah Anda menolak pengajuan presensi?</p>
            <div class="divider"></div>
            <div class="flex flex-col gap-2">
                <p><strong>Karyawan:</strong> <span id="tolak_karyawan"></span></p>
                <p><strong>Tanggal Pengajuan:</strong> <span id="tolak_tanggal"></span></p>
            </div>
            <div class="modal-action">
                <label for="modal_tolak" class="btn btn-ghost">Batal</label>
                <button class="btn btn-error" onclick="submitAction('tolak')">Tolak</button>
            </div>
        </div>
    </div>

    <!-- Modal Batal -->
    <input type="checkbox" id="modal_batal" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg">Pengajuan Presensi Dibatalkan</h3>
            <p class="py-4">Apakah Anda membatalkan pengajuan presensi?</p>
            <div class="divider"></div>
            <div class="flex flex-col gap-2">
                <p><strong>Karyawan:</strong> <span id="batal_karyawan"></span></p>
                <p><strong>Tanggal Pengajuan:</strong> <span id="batal_tanggal"></span></p>
            </div>
            <div class="modal-action">
                <label for="modal_batal" class="btn btn-ghost">Cancel</label>
                <button class="btn btn-error" onclick="submitAction('batal')">Batalkan</button>
            </div>
        </div>
    </div>

    <script>
        let currentModalData = {
            id: null,
            ajuan: null
        };

        let shouldReload = false;

        @if (session()->has("success"))
            document.getElementById('notification_title').textContent = 'Berhasil';
            document.getElementById('notification_message').textContent = '{{ session("success") }}';
            document.getElementById('modal_notification').checked = true;
            shouldReload = true;
        @endif

        @if (session()->has("error"))
            document.getElementById('notification_title').textContent = 'Gagal';
            document.getElementById('notification_message').textContent = '{{ session("error") }}';
            document.getElementById('modal_notification').checked = true;
        @endif

        function handleNotificationClose() {
            if (shouldReload) {
                location.reload();
            }
        }

        function setModalData(action, id, karyawan, tanggal) {
            currentModalData.id = id;
            currentModalData.ajuan = action;
            
            document.getElementById(action + '_karyawan').textContent = karyawan;
            document.getElementById(action + '_tanggal').textContent = tanggal;
        }

        function submitAction(action) {
            // Close the modal
            document.getElementById('modal_' + action).checked = false;

            $.ajax({
                type: "post",
                url: "{{ route("admin.administrasi-presensi.persetujuan") }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": currentModalData.id,
                    "ajuan": currentModalData.ajuan
                },
                success: function(response) {
                    document.getElementById('notification_title').textContent = 'Berhasil';
                    document.getElementById('notification_message').textContent = response.message;
                    document.getElementById('modal_notification').checked = true;
                    shouldReload = true;
                },
                error: function(response) {
                    document.getElementById('notification_title').textContent = 'Gagal';
                    document.getElementById('notification_message').textContent = response.responseJSON.message;
                    document.getElementById('modal_notification').checked = true;
                    shouldReload = false;
                }
            });
        }
    </script>
</x-app-layout>