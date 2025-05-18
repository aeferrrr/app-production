<?php

namespace App\Http\Controllers\Admin\Pembuatan;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Bahan;
use App\Models\ProdukBahan;
use Illuminate\Http\Request;

class ProdukBahanController extends Controller
{
    public function index(Request $request)
    {
        $query = ProdukBahan::with(['produk.produkBahan', 'bahan']);

        if ($request->has('search')) {
            $query->whereHas('produk', function ($q) use ($request) {
                $q->where('nama_produk', 'like', '%' . $request->search . '%');
            });
        }

        $produkBahan = $query->get()->groupBy('id_produk');
        $paginatedProduk = $query->paginate(10)->appends($request->all()); // untuk pagination

        $allBahan = Bahan::all();

        return view('admin.data-produk.produksi.read', [
            'produkGrouped' => $produkBahan,
            'allBahan' => $allBahan,
            'paginatedProduk' => $paginatedProduk,
        ]);
    }


    public function create()
    {
        $produk = Produk::all();
        $bahan = Bahan::all();
        return view('admin.data-produk.produksi.create', compact('produk', 'bahan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'id_bahan' => 'required|exists:bahan,id_bahan',
            'jumlah_bahan' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:10',
        ]);

        // Cek apakah relasi sudah ada
        $existing = ProdukBahan::where('id_produk', $request->id_produk)
            ->where('id_bahan', $request->id_bahan)
            ->first();

        if ($existing) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Relasi produk dan bahan ini sudah ada! Silakan cek kembali.');
        }

        ProdukBahan::create([
            'id_produk' => $request->id_produk,
            'id_bahan' => $request->id_bahan,
            'jumlah_bahan' => $request->jumlah_bahan,
            'satuan' => $request->satuan,
        ]);

        return redirect()->route('admin.produksi.item-produksi')
            ->with('success', 'Produk-bahan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $produkBahan = ProdukBahan::findOrFail($id);
        $produk = Produk::all();
        $bahan = Bahan::all();
        return view('admin.data-produk.produksi.edit', compact('produkBahan', 'produk', 'bahan'));
    }

    public function update(Request $request, $id_produk)
    {
        // Cek apakah id_produk_bahan yang diterima ada
        $produkBahanItem = ProdukBahan::find($request->id_produk_bahan);
    
        // Jika tidak ditemukan, return error
        if (!$produkBahanItem) {
            return redirect()->back()->with('error', 'Produk Bahan tidak ditemukan!');
        }
    
        // Validasi input
        $request->validate([
            'id_bahan' => 'required|exists:bahan,id_bahan',
            'jumlah_bahan' => 'required|numeric|min:0',
            'satuan' => 'required|string|max:10',
        ]);
    
        // Update data
        $produkBahanItem->update([
            'id_bahan' => $request->id_bahan,
            'jumlah_bahan' => $request->jumlah_bahan,
            'satuan' => $request->satuan,
        ]);
    
        return redirect()->route('admin.produksi.item-produksi')->with('success', 'Data bahan berhasil diperbarui!');
    }
    

    

    public function destroy($id)
    {
        // Mencari data produk bahan berdasarkan id
        $produkBahan = ProdukBahan::findOrFail($id);
    
        // Hapus data
        $produkBahan->delete();
    
        // Redirect dengan pesan sukses
        return redirect()->route('admin.produksi.item-produksi')
            ->with('success', 'Data Produk & Bahan berhasil dihapus!');
    }
    
}
