<x-app-layout>
    <x-slot name="header">
        <div class="navbar bg-base-100 shadow-sm rounded-box p-4 mb-5">
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-base-content">
                    {{ __('Lokasi Kantor') }}
                </h2>
            </div>
            <div class="flex-none">
                <label class="btn btn-primary btn-sm" for="create_modal">
                    <i class="ri-add-line mr-1"></i>
                    Tambah Data
                </label>
            </div>
        </div>
    </x-slot>

    <div class="container mx-auto px-4 md:px-8 py-6">
        <div class="card bg-base-100 shadow-xl">
            <div class="card-body p-0">
                <div class="overflow-x-auto">
                    <table class="table table-zebra w-full text-base-content">
                        <thead>
                            <tr>
                                <th class="w-10">No.</th>
                                <th>Kota</th>
                                <th>Alamat</th>
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Radius (m)</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($lokasiKantor as $value => $item)
                                <tr class="hover">
                                    <td class="font-bold">{{ $lokasiKantor->firstItem() + $value }}</td>
                                    <td>{{ $item->kota }}</td>
                                    <td>{{ $item->alamat }}</td>
                                    <td>{{ $item->latitude }}</td>
                                    <td>{{ $item->longitude }}</td>
                                    <td>{{ $item->radius }} m</td>
                                    <td>
                                        @if ($item->is_used)
                                            <div class="badge badge-success gap-2">
                                                <i class="ri-check-line"></i> Aktif
                                            </div>
                                        @else
                                            <div class="badge badge-neutral gap-2">
                                                <i class="ri-time-line"></i> Tidak Aktif
                                            </div>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="flex justify-center gap-2">
                                            <button type="button" class="btn btn-warning btn-sm tooltip"
                                                data-tip="Edit Lokasi"
                                                onclick="return edit_button('{{ $item->id }}')">
                                                <i class="ri-pencil-fill"></i>
                                            </button>
                                            <button type="button" class="btn btn-error btn-sm tooltip"
                                                data-tip="Hapus Lokasi"
                                                onclick="return delete_button('{{ $item->id }}', '{{ $item->kota }}')">
                                                <i class="ri-delete-bin-line"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-base-content">Tidak ada data lokasi
                                        kantor.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="p-4 pagination flex justify-center">
                    {{ $lokasiKantor->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Notification (Success/Error) --}}
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

    {{-- Modal Delete Confirmation --}}
    <input type="checkbox" id="modal_delete" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg text-warning">Hapus Lokasi Kantor?</h3>
            <p class="py-4">Anda akan menghapus data lokasi kantor berikut:</p>
            <div class="divider"></div>
            <div class="text-left mb-4">
                <p class="font-semibold">Kota: <span class="font-normal" id="delete_kota"></span></p>
            </div>
            <p class="text-error font-semibold">Tindakan ini tidak dapat dibatalkan!</p>
            <div class="modal-action">
                <label for="modal_delete" class="btn btn-ghost">Batal</label>
                <button class="btn btn-error" onclick="confirmDelete()">Ya, Hapus!</button>
            </div>
        </div>
    </div>

    {{-- Modal Error (untuk AJAX error) --}}
    <input type="checkbox" id="modal_error" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box">
            <h3 class="font-bold text-lg text-error">Gagal!</h3>
            <p class="py-4" id="error_message"></p>
            <div class="modal-action">
                <label for="modal_error" class="btn btn-primary">OK</label>
            </div>
        </div>
    </div>

    {{-- Awal Modal Create --}}
    <input type="checkbox" id="create_modal" class="modal-toggle" />
    <div class="modal" role="dialog">
        <div class="modal-box w-11/12 max-w-2xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-base-content">Tambah Lokasi Kantor</h3>
                <label for="create_modal" class="btn btn-sm btn-circle btn-ghost">
                    <i class="ri-close-line text-xl"></i>
                </label>
            </div>
            <div>
                <form action="{{ route('admin.lokasi-kantor.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">Kota<span class="text-error">*</span></span>
                            </div>
                            <input type="text" name="kota" placeholder="Contoh: Jakarta"
                                class="input input-bordered w-full" value="{{ old('kota') }}" required />
                            @error('kota')
                                <div class="label">
                                    <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                </div>
                            @enderror
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">Alamat Lengkap<span
                                        class="text-error">*</span></span>
                            </div>
                            <textarea name="alamat" placeholder="Contoh: Jl. Sudirman No. 123" class="textarea textarea-bordered w-full">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="label">
                                    <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                </div>
                            @enderror
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">Latitude<span class="text-error">*</span></span>
                            </div>
                            <input type="text" name="latitude" placeholder="Contoh: -6.208763"
                                class="input input-bordered w-full" value="{{ old('latitude') }}" required />
                            @error('latitude')
                                <div class="label">
                                    <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                </div>
                            @enderror
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">Longitude<span class="text-error">*</span></span>
                            </div>
                            <input type="text" name="longitude" placeholder="Contoh: 106.845599"
                                class="input input-bordered w-full" value="{{ old('longitude') }}" required />
                            @error('longitude')
                                <div class="label">
                                    <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                </div>
                            @enderror
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">Radius (meter)<span
                                        class="text-error">*</span></span>
                            </div>
                            <input type="number" min="0" name="radius" placeholder="Contoh: 100"
                                class="input input-bordered w-full" value="{{ old('radius') }}" required />
                            @error('radius')
                                <div class="label">
                                    <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                </div>
                            @enderror
                        </label>
                        <div>
                            <div class="label">
                                <span class="label-text font-semibold">Gunakan Lokasi Ini?<span
                                        class="text-error">*</span></span>
                            </div>
                            <div class="flex gap-4">
                                <label class="label cursor-pointer">
                                    <input type="radio" name="is_used" value='1' class="radio radio-primary"
                                        {{ old('is_used') == '1' ? 'checked' : '' }} />
                                    <span class="label-text ml-2">Ya</span>
                                </label>
                                <label class="label cursor-pointer">
                                    <input type="radio" name="is_used" value='0' class="radio radio-primary"
                                        {{ old('is_used') === '0' || old('is_used') === null ? 'checked' : '' }} />
                                    <span class="label-text ml-2">Tidak</span>
                                </label>
                            </div>
                            @error('is_used')
                                <div class="label">
                                    <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-action mt-6">
                        <button type="submit" class="btn btn-primary w-full sm:w-auto">Simpan Data</button>
                        <button type="button" class="btn btn-ghost w-full sm:w-auto"
                            onclick="document.getElementById('create_modal').checked = false;">Batal</button>
                    </div>
                </form>
            </div>
        </div>
        <label class="modal-backdrop" for="create_modal">Close</label>
    </div>
    {{-- Akhir Modal Create --}}

    {{-- Awal Modal Edit --}}
    <input type="checkbox" id="edit_modal" class="modal-toggle" />
    <div class="modal" role="dialog">
        <div class="modal-box w-11/12 max-w-2xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-2xl font-bold text-base-content">Ubah Lokasi Kantor</h3>
                <label for="edit_modal" class="btn btn-sm btn-circle btn-ghost">
                    <i class="ri-close-line text-xl"></i>
                </label>
            </div>
            <div>
                <form action="{{ route('admin.lokasi-kantor.update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="space-y-4">
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">
                                    Kota<span class="text-error">*</span>
                                    <span class="label-text-alt" id="loading_edit1"></span>
                                </span>
                            </div>
                            <input type="text" name="kota" placeholder="Kota"
                                class="input input-bordered w-full" required />
                            @error('kota')
                                <div class="label">
                                    <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                </div>
                            @enderror
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">
                                    Alamat Lengkap<span class="text-error">*</span>
                                    <span class="label-text-alt" id="loading_edit2"></span>
                                </span>
                            </div>
                            <textarea name="alamat" placeholder="Alamat" class="textarea textarea-bordered w-full"></textarea>
                            @error('alamat')
                                <div class="label">
                                    <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                </div>
                            @enderror
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">
                                    Latitude<span class="text-error">*</span>
                                    <span class="label-text-alt" id="loading_edit3"></span>
                                </span>
                            </div>
                            <input type="text" name="latitude" placeholder="Latitude"
                                class="input input-bordered w-full" required />
                            @error('latitude')
                                <div class="label">
                                    <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                </div>
                            @enderror
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">
                                    Longitude<span class="text-error">*</span>
                                    <span class="label-text-alt" id="loading_edit4"></span>
                                </span>
                            </div>
                            <input type="text" name="longitude" placeholder="Longitude"
                                class="input input-bordered w-full" required />
                            @error('longitude')
                                <div class="label">
                                    <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                </div>
                            @enderror
                        </label>
                        <label class="form-control w-full">
                            <div class="label">
                                <span class="label-text font-semibold">
                                    Radius (meter)<span class="text-error">*</span>
                                    <span class="label-text-alt" id="loading_edit6"></span>
                                </span>
                            </div>
                            <input type="number" min="0" name="radius" placeholder="Radius"
                                class="input input-bordered w-full" required />
                            @error('radius')
                                <div class="label">
                                    <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                </div>
                            @enderror
                        </label>
                        <div>
                            <div class="label">
                                <span class="label-text font-semibold">
                                    Gunakan Lokasi Ini?<span class="text-error">*</span>
                                    <span class="label-text-alt" id="loading_edit5"></span>
                                </span>
                            </div>
                            <div class="flex gap-4">
                                <label class="label cursor-pointer">
                                    <input type="radio" name="is_used" value='1'
                                        class="radio radio-primary" />
                                    <span class="label-text ml-2">Ya</span>
                                </label>
                                <label class="label cursor-pointer">
                                    <input type="radio" name="is_used" value='0'
                                        class="radio radio-primary" />
                                    <span class="label-text ml-2">Tidak</span>
                                </label>
                            </div>
                            @error('is_used')
                                <div class="label">
                                    <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-action mt-6">
                        <button type="submit" class="btn btn-primary w-full sm:w-auto">Perbarui Data</button>
                        <button type="button" class="btn btn-ghost w-full sm:w-auto"
                            onclick="document.getElementById('edit_modal').checked = false;">Batal</button>
                    </div>
                </form>
            </div>
        </div>
        <label class="modal-backdrop" for="edit_modal">Close</label>
    </div>
    {{-- Akhir Modal Edit --}}

    <script>
        let shouldReload = false;
        let deleteId = null;

        // Handle session messages
        @if (session()->has('success'))
            document.getElementById('notification_title').textContent = 'Berhasil!';
            document.getElementById('notification_message').textContent = '{{ session('success') }}';
            document.getElementById('modal_notification').checked = true;
            shouldReload = true;
        @endif

        @if (session()->has('error'))
            document.getElementById('notification_title').textContent = 'Gagal!';
            document.getElementById('notification_message').textContent = '{{ session('error') }}';
            document.getElementById('modal_notification').checked = true;
        @endif

        function handleNotificationClose() {
            if (shouldReload) {
                location.reload();
            }
        }

        function edit_button(id) {
            // Aktifkan modal edit
            document.getElementById('edit_modal').checked = true;

            // Loading effect start
            let loading = `<span class="loading loading-dots loading-sm text-primary"></span>`;
            $("#loading_edit1").html(loading);
            $("#loading_edit2").html(loading);
            $("#loading_edit3").html(loading);
            $("#loading_edit4").html(loading);
            $("#loading_edit5").html(loading);
            $("#loading_edit6").html(loading);

            $.ajax({
                type: "get",
                url: "{{ route('admin.lokasi-kantor.edit') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": id
                },
                success: function(data) {
                    let items = [];
                    $.each(data, function(key, val) {
                        items.push(val);
                    });

                    $("input[name='id']").val(items[0]);
                    $("input[name='kota']").val(items[1]);
                    $("textarea[name='alamat']").val(items[2]);
                    $("input[name='latitude']").val(items[3]);
                    $("input[name='longitude']").val(items[4]);
                    $("input[name='radius']").val(items[5]);
                    if (items[6] == 1) {
                        $("input[name='is_used'][value='1']").prop('checked', true);
                    } else if (items[6] == 0) {
                        $("input[name='is_used'][value='0']").prop('checked', true);
                    }

                    // Loading effect end
                    loading = "";
                    $("#loading_edit1").html(loading);
                    $("#loading_edit2").html(loading);
                    $("#loading_edit3").html(loading);
                    $("#loading_edit4").html(loading);
                    $("#loading_edit5").html(loading);
                    $("#loading_edit6").html(loading);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                    document.getElementById('error_message').textContent = 'Terjadi kesalahan saat memuat data.';
                    document.getElementById('modal_error').checked = true;
                    document.getElementById('edit_modal').checked = false;
                }
            });
        }

        function delete_button(id, kota) {
            deleteId = id;
            document.getElementById('delete_kota').textContent = kota;
            document.getElementById('modal_delete').checked = true;
        }

        function confirmDelete() {
            document.getElementById('modal_delete').checked = false;

            $.ajax({
                type: "post",
                url: "{{ route('admin.lokasi-kantor.delete') }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id": deleteId
                },
                success: function(response) {
                    document.getElementById('notification_title').textContent = 'Berhasil!';
                    document.getElementById('notification_message').textContent = response.message;
                    document.getElementById('modal_notification').checked = true;
                    shouldReload = true;
                },
                error: function(response) {
                    document.getElementById('error_message').textContent = response.responseJSON.message;
                    document.getElementById('modal_error').checked = true;
                }
            });
        }
    </script>
</x-app-layout>