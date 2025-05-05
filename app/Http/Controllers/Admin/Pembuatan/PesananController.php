<?php

namespace App\Http\Controllers\Admin\Pembuatan;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Produk;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    /**
     * Menampilkan daftar pesanan.
     */
    public function index(Request $request)
    {
        $pesananQuery = Pesanan::query();
    
        // Fitur pencarian berdasarkan kode atau nama pemesan
        if ($request->has('search')) {
            $pesananQuery->where(function ($query) use ($request) {
                $query->where('kode_pesanan', 'LIKE', '%' . $request->search . '%')
                      ->orWhere('nama_pemesan', 'LIKE', '%' . $request->search . '%');
            });
        }
    
        // Ambil semua data tanpa pagination
        $pesanan = $pesananQuery->with('detailPesanan.produk')->get(); // Get all matching data
    
        return view('admin.data-produk.pesanan.read', compact('pesanan'));
    }
    
    
    
    

    /**
     * Menampilkan form tambah pesanan.
     */
    public function create()
    {
        $produk = Produk::all();
        return view('admin.data-produk.pesanan.create', compact('produk'));
    }

    /**
     * Menyimpan pesanan baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_pesanan'     => 'required|unique:pesanan,kode_pesanan',
            'tanggal_pesanan'  => 'required|date',
            'nama_pemesan'     => 'required|string',
            'produk_id.*'      => 'required|exists:produk,id_produk',
            'jumlah.*'         => 'required|integer|min:1',
        ]);

        // Simpan data pesanan
        $pesanan = Pesanan::create([
            'kode_pesanan'     => $request->kode_pesanan,
            'tanggal_pesanan'  => $request->tanggal_pesanan,
            'nama_pemesan'     => $request->nama_pemesan,
            'catatan'          => $request->catatan,
        ]);

        // Simpan detail produk
        foreach ($request->produk_id as $key => $produkId) {
            DetailPesanan::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'id_produk'  => $produkId,
                'jumlah'     => $request->jumlah[$key],
            ]);
        }

        return redirect()->route('admin.produksi.item-pesanan')->with('success', 'Pesanan berhasil dibuat.');
    }

    /**
     * Menampilkan form edit pesanan.
     */
    public function edit($id)
    {
        $pesanan = Pesanan::with('detailPesanan')->findOrFail($id);
        $produk = Produk::all();
        return view('admin.data-produk.pesanan.edit', compact('pesanan', 'produk'));
    }

    /**
     * Menyimpan perubahan pesanan.
     */
    public function update(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);

        $request->validate([
            'kode_pesanan'     => 'required|unique:pesanan,kode_pesanan,' . $pesanan->id_pesanan . ',id_pesanan',
            'tanggal_pesanan'  => 'required|date',
            'nama_pemesan'     => 'required|string',
            'produk_id.*'      => 'required|exists:produk,id_produk',
            'jumlah.*'         => 'required|integer|min:1',
        ]);

        // Update data pesanan
        $pesanan->update([
            'kode_pesanan'     => $request->kode_pesanan,
            'tanggal_pesanan'  => $request->tanggal_pesanan,
            'nama_pemesan'     => $request->nama_pemesan,
            'catatan'          => $request->catatan,
        ]);

        // Hapus detail lama & buat ulang
        DetailPesanan::where('id_pesanan', $pesanan->id_pesanan)->delete();

        foreach ($request->produk_id as $key => $produkId) {
            DetailPesanan::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'id_produk'  => $produkId,
                'jumlah'     => $request->jumlah[$key],
            ]);
        }

        return redirect()->route('admin.produksi.item-pesanan')->with('success', 'Pesanan berhasil diperbarui.');
    }

    /**
     * Menghapus pesanan dari database.
     */
    public function destroy($id)
    {
        Pesanan::destroy($id);
        return redirect()->route('admin.produksi.item-pesanan')->with('success', 'Pesanan berhasil dihapus.');
    }
}
