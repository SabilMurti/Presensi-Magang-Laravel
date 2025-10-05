@extends("dashboard.layouts.main")

@section("container")
    <div class="container mx-auto p-4 sm:p-6 lg:p-8"> {{-- Container utama dengan padding responsif --}}
        <div class="card bg-base-100 shadow-xl border border-base-200 rounded-box transition-all duration-300 hover:shadow-2xl">
            <div class="card-body p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                    <h2 class="card-title text-base-content text-2xl font-semibold opacity-90 mb-4 sm:mb-0">{{ $title }}</h2>
                    <a href="{{ route("karyawan.izin") }}" class="btn btn-ghost btn-sm rounded-btn transition-all duration-300 hover:bg-base-200">
                        <i class="ri-arrow-left-line text-lg mr-1"></i>
                        Kembali
                    </a>
                </div>

                <form action="{{ route('karyawan.izin.store') }}" method="POST" enctype="multipart/form-data" id="pengajuanPresensiStore" class="mx-auto w-full lg:w-3/4 xl:w-1/2">
                    @csrf

                    {{-- Jenis Pengajuan --}}
                    <div class="form-control w-full mb-4">
                        <label class="label" for="status_select">
                            <span class="label-text font-semibold text-base-content opacity-80">Jenis Pengajuan <span class="text-error">*</span></span>
                        </label>
                        <select name="status" id="status_select" class="select select-bordered select-primary w-full" required>
                            <option disabled selected>Izin / Sakit</option>
                            @foreach ($statusPengajuan as $item)
                                <option value="{{ $item->value }}" {{ old('status') == $item->value ? 'selected' : '' }}>{{ $item->name }}</option>
                            @endforeach
                        </select>
                        @error("status")
                            <div class="label">
                                <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    {{-- Tanggal Pengajuan --}}
                    <div class="form-control w-full mb-4">
                        <label class="label" for="tanggal_pengajuan">
                            <span class="label-text font-semibold text-base-content opacity-80">Tanggal Pengajuan <span class="text-error">*</span></span>
                        </label>
                        <input type="date" name="tanggal_pengajuan" id="tanggal_pengajuan" placeholder="Tanggal Pengajuan" class="input input-bordered input-primary w-full" value="{{ old('tanggal_pengajuan') }}" required />
                        @error("tanggal_pengajuan")
                            <div class="label">
                                <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    {{-- Keterangan --}}
                    <div class="form-control w-full mb-6">
                        <label class="label" for="keterangan">
                            <span class="label-text font-semibold text-base-content opacity-80">Keterangan</span>
                        </label>
                        <textarea name="keterangan" id="keterangan" placeholder="Keterangan" class="textarea textarea-bordered textarea-primary w-full">{{ old('keterangan') }}</textarea>
                        @error("keterangan")
                            <div class="label">
                                <span class="label-text-alt text-sm text-error">{{ $message }}</span>
                            </div>
                        @enderror
                    </div>

                    <div class="mt-6 flex justify-center">
                        <button type="submit" class="btn btn-success btn-block lg:btn-wide rounded-btn text-white transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg">
                            <i class="ri-save-line mr-2 text-lg"></i>
                            Simpan Pengajuan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection 