<?php

namespace App\Http\Controllers\Admin\Produk;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use Illuminate\Http\Request;

class BahanController extends Controller
{
    /**
     * Menampilkan daftar bahan.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $bahan = Bahan::when($search, function ($query, $search) {
            return $query->where('nama_bahan', 'like', "%{$search}%")
                        ->orWhere('kode_bahan', 'like', "%{$search}%");
        })->paginate(5);

        return view('admin.data-master.bahan-item.read', compact('bahan'));
    }


    /**
     * Menampilkan form tambah bahan.
     */
    public function create()
    {
        return view('admin.data-master.bahan-item.create');
    }

    /**
     * Menyimpan bahan baru ke database.
     */
    public function store(Request $request)
{
    $request->validate([
        'kode_bahan' => 'required|unique:bahan,kode_bahan|max:10',
        'nama_bahan' => 'required|unique:bahan,nama_bahan|max:32',
        'harga_bahan' => 'required|numeric|max:11',
        'satuan' => 'required|max:15'
    ], [
        'kode_bahan.required' => 'Kode bahan wajib diisi.',
        'kode_bahan.unique' => 'Kode bahan sudah digunakan.',
        'kode_bahan.max' => 'Kode bahan melebihi maksimal.',
        'nama_bahan.required' => 'Nama bahan wajib diisi.',
        'nama_bahan.unique' => 'Nama bahan sudah digunakan.',
        'nama_bahan.max' => 'Nama bahan melebihi maksimal.',
        'harga_bahan.required' => 'Harga bahan wajib diisi.',
        'harga_bahan.numeric' => 'Harga bahan harus berupa angka.',
        'harga_bahan.max' => 'Harga bahan melebihi maksimal.',
        'satuan.required' => 'Satuan bahan wajib diisi.',
        'satuan.max' => 'Satuan bahan melebihi maksimal.',
    ]);

    Bahan::create([
        'kode_bahan' => $request->kode_bahan,
        'nama_bahan' => $request->nama_bahan,
        'harga_bahan' => $request->harga_bahan,
        'satuan' => $request->satuan,
    ]);

    return redirect()->route('admin.bahan.item-bahan')->with('success', 'Bahan berhasil ditambahkan!');
}


    /**
     * Menampilkan form edit bahan.
     */
    public function edit($id)
    {
        $bahan = Bahan::findOrFail($id);
        return view('admin.data-master.bahan-item.edit', compact('bahan'));
    }

    /**
     * Update data bahan di database.
     */
public function update(Request $request, $id)
{
    $request->validate([
        'kode_bahan' => 'required|unique:bahan,kode_bahan,'.$id.',id_bahan|max:10',
        'nama_bahan' => 'required|max:32',
        'harga_bahan' => 'required|numeric|max:11',
        'satuan' => 'required|max:15'
    ], [
        'kode_bahan.required' => 'Kode bahan wajib diisi.',
        'kode_bahan.unique' => 'Kode bahan sudah digunakan.',
        'kode_bahan.max' => 'Kode bahan melebihi maksimal.',
        'nama_bahan.required' => 'Nama bahan wajib diisi.',
        'nama_bahan.max' => 'Nama bahan melebihi maksimal.',
        'harga_bahan.required' => 'Harga bahan wajib diisi.',
        'harga_bahan.numeric' => 'Harga bahan harus berupa angka.',
        'harga_bahan.max' => 'Harga bahan melebihi maksimal.',
        'satuan.required' => 'Satuan bahan wajib diisi.',
        'satuan.max' => 'Satuan bahan melebihi maksimal.',
    ]);

    $bahan = Bahan::findOrFail($id);
    $bahan->update([
        'kode_bahan' => $request->kode_bahan,
        'nama_bahan' => $request->nama_bahan,
        'harga_bahan' => $request->harga_bahan,
        'satuan' => $request->satuan,
    ]);

    return redirect()->route('admin.bahan.item-bahan')->with('success', 'Bahan berhasil diperbarui!');
}


    /**
     * Menghapus bahan dari database.
     */
    public function destroy($id)
    {
        $bahan = Bahan::findOrFail($id);
        $bahan->delete();

        return redirect()->route('admin.bahan.item-bahan')->with('success', 'Bahan berhasil dihapus!');
    }

    public function updateHarga(Request $request)
{
    $request->validate([
        'id' => 'required|exists:bahan,id_bahan',
        'harga_bahan' => 'required|numeric',
    ]);

    $bahan = Bahan::findOrFail($request->id);
    $bahan->update(['harga_bahan' => $request->harga_bahan]);

    return response()->json(['success' => true, 'message' => 'Harga berhasil diperbarui!']);
}

}
