<?php

namespace App\Http\Controllers\Admin\Produk;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Menampilkan daftar produk.
     */
    public function index(Request $request)
    {
        $produk = Produk::query();

        // Fitur pencarian berdasarkan kode atau nama produk
        if ($request->has('search')) {
            $produk->where('kode_produk', 'LIKE', '%' . $request->search . '%')
                   ->orWhere('nama_produk', 'LIKE', '%' . $request->search . '%');
        }

        // Pagination 5 data per halaman
        $produk = $produk->paginate(5);

        return view('admin.data-master.produk-item.read', compact('produk'));
    }

    /**
     * Menampilkan form tambah produk.
     */
    public function create()
    {
        return view('admin.data-master.produk-item.create');
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|unique:produk,kode_produk|max:255',
            'nama_produk' => 'required|string|max:255',
        ], [
            'kode_produk.required' => 'Kode produk wajib diisi.',
            'kode_produk.unique' => 'Kode produk sudah digunakan.',
            'kode_produk.max' => 'Kode produk tidak boleh lebih dari 255 karakter.',
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'nama_produk.string' => 'Nama produk harus berupa teks.',
            'nama_produk.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',
        ]);

        Produk::create([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
        ]);

        return redirect()->route('admin.produk.item-produk')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit produk.
     */
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('admin.data-master.produk-item.edit', compact('produk'));
    }

    /**
     * Menyimpan perubahan produk.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_produk' => 'required|max:255|unique:produk,kode_produk,' . $id . ',id_produk',
            'nama_produk' => 'required|string|max:255',
        ], [
            'kode_produk.required' => 'Kode produk wajib diisi.',
            'kode_produk.unique' => 'Kode produk sudah digunakan.',
            'kode_produk.max' => 'Kode produk tidak boleh lebih dari 255 karakter.',
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'nama_produk.string' => 'Nama produk harus berupa teks.',
            'nama_produk.max' => 'Nama produk tidak boleh lebih dari 255 karakter.',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->update([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
        ]);

        return redirect()->route('admin.produk.item-produk')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk dari database.
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus!');
    }
}
