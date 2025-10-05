<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DepartemenController extends Controller
{
    public function index(Request $request)
    {
        $title = "Data Departemen";

        $query = Departemen::orderBy('kode', 'asc');
        if ($request->cari_departemen) {
            $query->where('nama', 'like', '%' . $request->cari_departemen . '%');
            $query->orWhere('kode', 'like', '%' . $request->cari_departemen . '%');
        }
        $departemen = $query->paginate(10);

        return view('admin.departemen.index', compact('title', 'departemen'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode' => 'required|unique:departemen,kode',
            'nama' => 'required|string|max:255',
        ]);

        $create = Departemen::create($data);

        if ($create) {
            return to_route('admin.departemen')->with('success', 'Data Departemen berhasil disimpan');
        } else {
            return to_route('admin.departemen')->with('error', 'Data Departemen gagal disimpan');
        }
    }

    public function edit(Request $request)
    {
        $data = Departemen::where('id', $request->id)->first();
        return $data;
    }

    public function update(Request $request)
    {
        $departemen = Departemen::where('id', $request->id)->first();
        $data = $request->validate([
            'kode' => ['required', Rule::unique('departemen')->ignore($departemen)],
            'nama' => 'required|string|max:255',
        ]);

        $update = Departemen::where('id', $request->id)->update($data);

        if ($update) {
            return to_route('admin.departemen')->with('success', 'Data Departemen berhasil diperbarui');
        } else {
            return to_route('admin.departemen')->with('error', 'Data Departemen gagal diperbarui');
        }
    }

    public function delete(Request $request)
    {
        try {
            $departemen = Departemen::findOrFail($request->id);
            $departemen->delete();

            return response()->json([
                'message' => 'Departemen berhasil dihapus.',
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                // Error karena relasi foreign key
                return response()->json([
                    'message' => 'Tidak dapat menghapus departemen ini karena masih ada karyawan yang terdaftar di departemen tersebut.',
                ], 400);
            }

            // Error umum lainnya
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus departemen.',
                'error' => $e->getMessage()
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan tak terduga.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
