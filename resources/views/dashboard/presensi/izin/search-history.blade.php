@if ($data->isEmpty())
    <div role="alert" class="alert alert-warning my-5 rounded-lg shadow-md border-base-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        <span>Tidak ada data pengajuan izin/sakit untuk periode ini.</span>
    </div>
@else
    <table class="table w-full"> {{-- DaisyUI table class --}}
        {{-- head --}}
        <thead>
            <tr class="bg-base-200 text-base-content opacity-80">
                <th></th>
                <th>Hari</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th>Approved</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $value => $item)
                <tr class="hover:bg-base-200"> {{-- Hover effect for table rows --}}
                    <td class="font-bold text-base-content">{{ $value + 1 }}</td>
                    <td class="text-base-content opacity-80">{{ date("l", strtotime($item->tanggal_pengajuan)) }}</td>
                    <td class="text-base-content opacity-80">{{ date("d-m-Y", strtotime($item->tanggal_pengajuan)) }}</td>
                    <td class="text-base-content opacity-80">
                        @if ($item->status == "I")
                            Izin
                        @elseif ($item->status == "S")
                            Sakit
                        @endif
                    </td>
                    <td>
                        @if ($item->status_approved == 0)
                            <div class="badge badge-warning text-warning-content font-semibold">Pending</div>
                        @elseif ($item->status_approved == 1)
                            <div class="badge badge-success text-success-content font-semibold">Disetujui</div>
                        @elseif ($item->status_approved == 2)
                            <div class="badge badge-error text-error-content font-semibold">Ditolak</div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- Pagination (jika $data adalah objek paginator) --}}
    @if (method_exists($data, 'links'))
        <div class="p-4 border-t border-base-200 bg-base-200 rounded-b-lg flex justify-center">
            {{ $data->links("pagination::tailwind") }}
        </div>
    @endif
@endif