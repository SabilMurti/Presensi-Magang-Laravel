<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


// Tambahkan use statement untuk PhpSpreadsheet
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\DB; // Untuk transaksi database

use App\Http\Traits\ExcelExportTrait;
class KaryawanController extends Controller
{

    use ExcelExportTrait;


    // public function indexAdmin(Request $request)
    // {
    //     $title = "Data Karyawan Magang"; // Perbarui judul sesuai permintaan sebelumnya

    //     $departemen = Departemen::get();

    //     $query = Karyawan::join('departemen as d', 'karyawan.departemen_id', '=', 'd.id')
    //         ->select('karyawan.nik', 'd.nama as nama_departemen', 'karyawan.nama_lengkap', 'karyawan.foto', 'karyawan.jabatan', 'karyawan.telepon', 'karyawan.email', 'karyawan.departemen_id') // Tambah departemen_id untuk keperluan export
    //         ->orderBy('d.kode', 'asc')
    //         ->orderBy('karyawan.nama_lengkap', 'asc');

    //     if ($request->nama_karyawan) {
    //         $query->where('karyawan.nama_lengkap', 'like', '%' . $request->nama_karyawan . '%');
    //     }
    //     if ($request->kode_departemen) {
    //         $query->where('d.kode', 'like', '%' . $request->kode_departemen . '%');
    //     }
    //     $karyawan = $query->paginate(10);

    //     return view('admin.karyawan.index', compact('title', 'karyawan', 'departemen'));
    // }

    public function exportKaryawan()
    {
        $fileName = 'data_karyawan_' . Carbon::now()->format('Ymd_His');

        $headings = [
            'NIK',
            'ID Departemen', // Untuk referensi
            'Nama Instansi', // Jika ingin ada nama instansi di export
            'Nama Lengkap',
            'Posisi',
            'Telepon',
            'Email'
        ];

        // Ambil data dari database
        $karyawanData = Karyawan::join('departemen as d', 'karyawan.departemen_id', '=', 'd.id')
            ->select(
                'karyawan.nik',
                'karyawan.departemen_id', // ID departemen penting untuk import
                'd.nama as nama_departemen', // Nama departemen untuk informasi
                'karyawan.nama_lengkap',
                'karyawan.jabatan', // 'jabatan' dari DB akan jadi 'Posisi' di Excel
                'karyawan.telepon',
                'karyawan.email'
            )
            ->get();

        // Siapkan data dalam format array untuk diexport
        $exportData = $karyawanData->map(function ($item) {
            return [
                $item->nik,
                $item->departemen_id,
                $item->nama_departemen,
                $item->nama_lengkap,
                $item->jabatan,
                $item->telepon,
                $item->email
            ];
        });

        return $this->exportDataToExcel($fileName, $headings, $exportData, 'xlsx'); // Bisa juga 'csv'
    }

    public function importKaryawan(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ], [
            'file.required' => 'Harap pilih file untuk diunggah.',
            'file.mimes' => 'File harus berformat Excel (xlsx, xls) atau CSV.',
        ]);

        $file = $request->file('file');
        $filePath = $file->getRealPath();
        $spreadsheet = IOFactory::load($filePath);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        // Asumsi baris pertama adalah header
        $header = array_map('trim', $sheetData[1]); // Membersihkan spasi di header
        unset($sheetData[1]); // Hapus baris header dari data

        $expectedHeaders = [
            'NIK',
            'ID Departemen', // Atau 'Nama Instansi' jika import menggunakan nama
            'Nama Lengkap',
            'Posisi',
            'Telepon',
            'Email',
            'Password' // Password bisa opsional
        ];

        // Validasi header
        foreach ($expectedHeaders as $expected) {
            if (!in_array($expected, $header)) {
                if ($expected === 'Password') {
                    continue; // Password bisa opsional, abaikan jika tidak ada di header
                }
                return to_route('admin.karyawan')->with('error', "Kolom '$expected' tidak ditemukan di file Excel/CSV. Harap periksa template.");
            }
        }

        $importedRows = [];
        $errors = [];

        DB::beginTransaction(); // Mulai transaksi database
        try {
            foreach ($sheetData as $rowNum => $row) {
                // Lewati baris kosong
                if (empty(array_filter($row))) {
                    continue;
                }

                // Mapping kolom berdasarkan header
                $data = [];
                foreach ($header as $colLetter => $colName) {
                    $data[$colName] = $row[$colLetter] ?? null;
                }

                // Data yang akan diimpor
                $nik = $data['NIK'] ?? null;
                $departemenIdentifier = $data['ID Departemen'] ?? ($data['Nama Instansi'] ?? null); // Bisa ID atau Nama
                $namaLengkap = $data['Nama Lengkap'] ?? null;
                $jabatan = $data['Posisi'] ?? null;
                $telepon = $data['Telepon'] ?? null;
                $email = $data['Email'] ?? null;
                $password = $data['Password'] ?? null;

                // Validasi data (sangat penting untuk import)
                $rules = [
                    'nik' => 'required|string|max:255',
                    'departemen_identifier' => 'required',
                    'nama_lengkap' => 'required|string|max:255',
                    'jabatan' => 'required|string|max:255',
                    'telepon' => 'required|string|max:15',
                    'email' => 'required|string|email|max:255',
                    'password' => 'nullable|string|min:6',
                ];

                $validator = \Illuminate\Support\Facades\Validator::make([
                    'nik' => $nik,
                    'departemen_identifier' => $departemenIdentifier,
                    'nama_lengkap' => $namaLengkap,
                    'jabatan' => $jabatan,
                    'telepon' => $telepon,
                    'email' => $email,
                    'password' => $password,
                ], $rules);

                if ($validator->fails()) {
                    $errors[] = "Baris " . $rowNum . ": " . implode(", ", $validator->errors()->all());
                    continue; // Lanjut ke baris berikutnya
                }

                // Temukan ID Departemen
                $departemenId = null;
                if (is_numeric($departemenIdentifier)) {
                    $departemen = Departemen::find($departemenIdentifier);
                } else {
                    $departemen = Departemen::where('nama', $departemenIdentifier)->first();
                }

                if (!$departemen) {
                    $errors[] = "Baris " . $rowNum . ": Instansi '$departemenIdentifier' tidak ditemukan.";
                    continue;
                }
                $departemenId = $departemen->id;

                // Cek NIK dan Email unik
                $existingKaryawan = Karyawan::where('nik', $nik)->first();
                if ($existingKaryawan && $existingKaryawan->email !== $email) {
                    // Jika NIK sama tapi email beda, ini adalah konflik data
                    $errors[] = "Baris " . $rowNum . ": NIK '$nik' sudah ada dengan email yang berbeda. Harap perbaiki atau hapus data lama.";
                    continue;
                }
                $existingEmailKaryawan = Karyawan::where('email', $email)->first();
                if ($existingEmailKaryawan && $existingEmailKaryawan->nik !== $nik) {
                    // Jika Email sama tapi NIK beda, ini adalah konflik data
                    $errors[] = "Baris " . $rowNum . ": Email '$email' sudah digunakan oleh karyawan dengan NIK berbeda. Harap perbaiki atau hapus data lama.";
                    continue;
                }


                $karyawanData = [
                    'departemen_id' => $departemenId,
                    'nama_lengkap' => $namaLengkap,
                    'jabatan' => $jabatan,
                    'telepon' => $telepon,
                    'email' => $email,
                ];

                if ($password) {
                    $karyawanData['password'] = Hash::make($password);
                }

                if ($existingKaryawan) {
                    // Update karyawan yang sudah ada
                    Karyawan::where('nik', $nik)->update($karyawanData);
                } else {
                    // Buat karyawan baru (pastikan password ada untuk karyawan baru)
                    if (!$password) {
                        $errors[] = "Baris " . $rowNum . ": Password wajib diisi untuk karyawan baru dengan NIK '$nik'.";
                        continue;
                    }
                    Karyawan::create(array_merge(['nik' => $nik], $karyawanData));
                }
                $importedRows[] = $rowNum;
            }

            if (!empty($errors)) {
                DB::rollBack(); // Rollback jika ada error validasi
                $errorMessage = "Gagal mengimpor data. Beberapa baris memiliki kesalahan:<br>";
                foreach ($errors as $error) {
                    $errorMessage .= "- " . $error . "<br>";
                }
                return to_route('admin.karyawan')->with('error', $errorMessage);
            }

            DB::commit(); // Commit transaksi jika semua berhasil
            return to_route('admin.karyawan')->with('success', 'Data Karyawan berhasil diimpor (' . count($importedRows) . ' baris).');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback jika terjadi exception
            return to_route('admin.karyawan')->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $title = "Profile";
        $karyawan = Karyawan::where('nik', auth()->guard('karyawan')->user()->nik)->first();
        return view('dashboard.profile.index', compact('title', 'karyawan'));
    }

    public function update(Request $request)
    {
        $karyawan = Karyawan::where('nik', auth()->guard('karyawan')->user()->nik)->first();

        if ($request->hasFile('foto')) {
            $foto = $karyawan->nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $karyawan->foto;
        }

        if ($request->password != null) {
            $update = Karyawan::where('nik', auth()->guard('karyawan')->user()->nik)->update([
                'nama_lengkap' => $request->nama_lengkap,
                'telepon' => $request->telepon,
                'password' => Hash::make($request->password),
                'foto' => $foto,
                'updated_at' => Carbon::now(),
            ]);
        } elseif ($request->password == null) {
            $update = Karyawan::where('nik', auth()->guard('karyawan')->user()->nik)->update([
                'nama_lengkap' => $request->nama_lengkap,
                'telepon' => $request->telepon,
                'foto' => $foto,
                'updated_at' => Carbon::now(),
            ]);
        }

        if ($update) {
            if ($request->hasFile('foto')) {
                $folderPath = "public/unggah/karyawan/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return redirect()->back()->with('success', 'Profile updated successfully');
        } else {
            return redirect()->back()->with('error', 'Profile updated failed');
        }
    }

    public function indexAdmin(Request $request)
    { {
            $title = "Data Karyawan Magang"; // Perbarui judul sesuai permintaan sebelumnya

            $departemen = Departemen::get();

            $query = Karyawan::join('departemen as d', 'karyawan.departemen_id', '=', 'd.id')
                ->select('karyawan.nik', 'd.nama as nama_departemen', 'karyawan.nama_lengkap', 'karyawan.foto', 'karyawan.jabatan', 'karyawan.telepon', 'karyawan.email', 'karyawan.departemen_id') // Tambah departemen_id untuk keperluan export
                ->orderBy('d.kode', 'asc')
                ->orderBy('karyawan.nama_lengkap', 'asc');

            if ($request->nama_karyawan) {
                $query->where('karyawan.nama_lengkap', 'like', '%' . $request->nama_karyawan . '%');
            }
            if ($request->kode_departemen) {
                $query->where('d.kode', 'like', '%' . $request->kode_departemen . '%');
            }
            $karyawan = $query->paginate(10);

            return view('admin.karyawan.index', compact('title', 'karyawan', 'departemen'));
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nik' => 'required|unique:karyawan,nik',
            'departemen_id' => 'required',
            'nama_lengkap' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jabatan' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:karyawan,email',
            'password' => 'required',
        ]);
        $data['password'] = Hash::make($data['password']);
        if ($request->hasFile('foto')) {
            $foto = $request->nik . "." . $request->file('foto')->getClientOriginalExtension();
        }

        $create = Karyawan::create($data);

        if ($create) {
            if ($request->hasFile('foto')) {
                $folderPath = "public/unggah/karyawan/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return to_route('admin.karyawan')->with('success', 'Data Karyawan berhasil disimpan');
        } else {
            return to_route('admin.karyawan')->with('error', 'Data Karyawan gagal disimpan');
        }
    }

    public function edit(Request $request)
    {
        $data = Karyawan::where('nik', $request->nik)->first();
        return $data;
    }

    public function updateAdmin(Request $request)
    {
        $karyawan = Karyawan::where('nik', $request->nik_lama)->first();
        $data = $request->validate([
            'nik' => ['required', Rule::unique('karyawan')->ignore($karyawan)],
            'departemen_id' => 'required',
            'nama_lengkap' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jabatan' => 'required|string|max:255',
            'telepon' => 'required|string|max:15',
            'email' => ['required', 'email', Rule::unique('karyawan')->ignore($karyawan)],
        ]);
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->nik . "." . $request->file('foto')->getClientOriginalExtension();
        }

        $update = Karyawan::where('nik', $request->nik_lama)->update($data);

        if ($update) {
            if ($request->hasFile('foto')) {
                $folderPath = "public/unggah/karyawan/";
                $request->file('foto')->storeAs($folderPath, $data['foto']);
            }
            return to_route('admin.karyawan')->with('success', 'Data Karyawan berhasil diperbarui');
        } else {
            return to_route('admin.karyawan')->with('error', 'Data Karyawan gagal diperbarui');
        }
    }

    public function delete(Request $request)
    {
        try {
            $data = Karyawan::where('nik', $request->nik)->firstOrFail();

            // Simpan nama file sebelum delete
            $foto = $data->foto;

            // Coba hapus data
            $delete = $data->delete();

            // Jika berhasil dan ada foto, hapus dari storage
            if ($delete && $foto) {
                $folderPath = "public/unggah/karyawan/";
                Storage::delete($folderPath . $foto);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data karyawan berhasil dihapus.'
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                // Ini adalah error karena foreign key constraint
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat menghapus karyawan ini karena masih memiliki data pengajuan presensi yang terhubung.'
                ], 400);
            }

            // Error SQL lain
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada database: ' . $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            // Error umum lainnya
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ], 500);
        }
    }
}
