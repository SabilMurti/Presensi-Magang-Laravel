<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold leading-tight text-base-content">
                {{ __("Data Instansi") }}
            </h2>
            <label class="btn btn-primary btn-md rounded-full shadow-md hover:shadow-lg transition-all duration-200" for="create_modal">
                <i class="ri-add-line mr-1"></i>
                Tambah Data
            </label>
        </div>
    </x-slot>

    <div class="container mx-auto py-6 px-4 sm:px-6 lg:px-8">
        {{-- Search Form --}}
        <div class="bg-base-100 shadow-lg rounded-lg p-6 mb-6 border border-base-200">
            <form action="{{ route('admin.departemen') }}" method="get">
                <div class="flex flex-col md:flex-row gap-4 items-end">
                    <div class="form-control w-full md:flex-1">
                        <label class="label">
                            <span class="label-text text-base-content">Cari Instansi</span>
                        </label>
                        <input type="text" name="cari_departemen" placeholder="Cari berdasarkan nama atau kode..." class="input input-bordered w-full focus:ring-primary focus:border-primary" value="{{ request()->cari_departemen }}" />
                    </div>
                    <button type="submit" class="btn btn-primary w-full md:w-auto h-full px-8 py-3 rounded-md shadow-md hover:shadow-lg transition-all duration-200 mt-4 md:mt-0">
                        <i class="ri-search-2-line text-lg"></i>
                        <span class="md:hidden">Cari</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- Data Table --}}
        <div class="w-full overflow-x-auto rounded-lg shadow-lg border border-base-200 bg-base-100">
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th class="text-base-content text-opacity-80">No</th>
                        <th class="text-base-content text-opacity-80">Kode</th>
                        <th class="text-base-content text-opacity-80">Nama</th>
                        <th class="text-base-content text-opacity-80">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departemen as $value => $item)
                        <tr>
                            <td class="font-bold text-base-content">{{ $departemen->firstItem() + $value }}</td>
                            <td class="text-base-content text-opacity-70">{{ $item->kode }}</td>
                            <td class="text-base-content text-opacity-70">{{ $item->nama }}</td>
                            <td>
                                <div class="flex gap-2">
                                    <label class="btn btn-warning btn-sm btn-circle shadow-md hover:shadow-lg transition-all duration-200" onclick="edit_modal_show('{{ $item->id }}', '{{ $item->kode }}', '{{ $item->nama }}')">
                                        <i class="ri-pencil-fill text-lg"></i>
                                    </label>
                                    <label class="btn btn-error btn-sm btn-circle shadow-md hover:shadow-lg transition-all duration-200" onclick="delete_button('{{ $item->id }}', '{{ $item->nama }}')">
                                        <i class="ri-delete-bin-line text-lg"></i>
                                    </label>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4 pagination">
                {{ $departemen->links() }}
            </div>
        </div>
    </div>

    {{-- Modal Create --}}
    <input type="checkbox" id="create_modal" class="modal-toggle" />
    <div class="modal" role="dialog">
        <div class="modal-box bg-base-100 text-base-content shadow-xl border border-base-200">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-xl font-bold">Tambah Data Instansi</h3>
                <label for="create_modal" class="btn btn-sm btn-circle btn-ghost text-base-content">
                    <i class="ri-close-large-fill text-xl"></i>
                </label>
            </div>
            <form action="{{ route('admin.departemen.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold text-base-content">Kode Instansi<span class="text-error">*</span></span>
                    </label>
                    <input type="text" name="kode" placeholder="Masukkan Kode Instansi" class="input input-bordered w-full focus:ring-primary focus:border-primary" required />
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold text-base-content">Nama Instansi<span class="text-error">*</span></span>
                    </label>
                    <input type="text" name="nama" placeholder="Masukkan Nama Instansi" class="input input-bordered w-full focus:ring-primary focus:border-primary" required />
                </div>
                <div class="modal-action mt-6">
                    <button type="submit" class="btn btn-primary w-full text-white shadow-md hover:shadow-lg transition-all duration-200">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <input type="checkbox" id="edit_modal" class="modal-toggle" />
    <div class="modal" role="dialog">
        <div class="modal-box bg-base-100 text-base-content shadow-xl border border-base-200">
            <div class="mb-4 flex items-center justify-between">
                <h3 class="text-xl font-bold">Ubah Data Instansi</h3>
                <label for="edit_modal" class="btn btn-sm btn-circle btn-ghost text-base-content">
                    <i class="ri-close-large-fill text-xl"></i>
                </label>
            </div>
            <form action="{{ route('admin.departemen.update') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="id" id="edit_id">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold text-base-content">Kode Instansi<span class="text-error">*</span></span>
                    </label>
                    <input type="text" name="kode" id="edit_kode" class="input input-bordered w-full focus:ring-primary focus:border-primary" required />
                </div>
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold text-base-content">Nama Instansi<span class="text-error">*</span></span>
                    </label>
                    <input type="text" name="nama" id="edit_nama" class="input input-bordered w-full focus:ring-primary focus:border-primary" required />
                </div>
                <div class="modal-action mt-6">
                    <button type="submit" class="btn btn-warning w-full text-white shadow-md hover:shadow-lg transition-all duration-200">Perbarui Data</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <input type="checkbox" id="delete_modal" class="modal-toggle" />
    <div class="modal" role="dialog">
        <div class="modal-box bg-base-100 border border-base-200 text-base-content">
            <h3 class="font-bold text-lg text-error">Konfirmasi Hapus</h3>
            <p class="py-2 text-base-content text-opacity-80">Apakah Anda yakin ingin menghapus data ini?</p>
            <div class="divider"></div>
            <div class="text-center">
                <p class="font-bold text-base-content" id="delete_nama"></p>
                <p class="text-sm text-base-content text-opacity-60" id="delete_id"></p>
            </div>
            <div class="modal-action">
                <label for="delete_modal" class="btn">Batal</label>
                <button type="button" class="btn btn-error" onclick="confirmDelete()">Ya, Hapus</button>
            </div>
        </div>
    </div>

    {{-- Modal Notifikasi --}}
    <input type="checkbox" id="modal_notification" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box bg-base-100 border border-base-200 text-base-content">
            <h3 id="notification_title" class="font-bold text-lg text-success">Berhasil!</h3>
            <p id="notification_message" class="py-4">Data berhasil dihapus.</p>
            <div class="modal-action">
                <label for="modal_notification" class="btn btn-success">OK</label>
            </div>
        </div>
    </div>

    {{-- Modal Error --}}
    <input type="checkbox" id="modal_error" class="modal-toggle" />
    <div class="modal">
        <div class="modal-box bg-base-100 border border-base-200 text-base-content">
            <h3 class="font-bold text-lg text-error">Gagal!</h3>
            <p id="error_message" class="py-4">Terjadi kesalahan.</p>
            <div class="modal-action">
                <label for="modal_error" class="btn btn-error">OK</label>
            </div>
        </div>
    </div>

    {{-- Script --}}
    <script>
        let deleteId = null;
        let shouldReload = false;

        function edit_modal_show(id, kode, nama) {
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_kode').value = kode;
            document.getElementById('edit_nama').value = nama;
            document.getElementById('edit_modal').checked = true;
        }

        function delete_button(id, nama) {
            deleteId = id;
            document.getElementById('delete_nama').textContent = `Instansi: ${nama}`;
            document.getElementById('delete_id').textContent = `ID: ${id}`;
            document.getElementById('delete_modal').checked = true;
        }

        function confirmDelete() {
            document.getElementById('delete_modal').checked = false;

            $.ajax({
                type: "post",
                url: "{{ route('admin.departemen.delete') }}",
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
                    document.getElementById('error_message').textContent = response.responseJSON?.message || 'Terjadi kesalahan saat menghapus data.';
                    document.getElementById('modal_error').checked = true;
                }
            });
        }

        document.getElementById('modal_notification').addEventListener('change', function(e) {
            if (!e.target.checked && shouldReload) {
                location.reload();
            }
        });
    </script>
</x-app-layout>
