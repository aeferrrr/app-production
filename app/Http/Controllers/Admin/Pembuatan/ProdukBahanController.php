<?php

namespace App\Http\Controllers\Admin\Pembuatan;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Bahan;
use App\Models\ProdukBahan;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator; 

class ProdukBahanController extends Controller
{
    public function index(Request $request)
{
    // Ambil semua data produk bahan
    $query = ProdukBahan::with(['produk', 'bahan']);

    // Kalau ada pencarian
    if ($request->has('search')) {
        $query->whereHas('produk', function ($q) use ($request) {
            $q->where('nama_produk', 'like', '%' . $request->search . '%');
        });
    }

    // Ambil data dan group by id_produk
    $grouped = $query->get()->groupBy('id_produk');

    // Ubah hasil group jadi collection indexed
    $groupedList = $grouped->map(function ($items) {
        return $items;
    })->values();

    // Manual pagination
    $perPage = 5;
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $currentItems = $groupedList->slice(($currentPage - 1) * $perPage, $perPage)->values();

    $paginatedGrouped = new LengthAwarePaginator(
        $currentItems,
        $groupedList->count(),
        $perPage,
        $currentPage,
        ['path' => $request->url(), 'query' => $request->query()]
    );

    // Ambil semua bahan untuk select option
    $allBahan = Bahan::orderBy('nama_bahan', 'asc')->get();

    return view('admin.data-produk.produksi.read', compact('paginatedGrouped', 'allBahan'));
}


    public function create()
    {
        $produk = Produk::all();
        $bahan = Bahan::orderBy('nama_bahan', 'asc')->get();
        return view('admin.data-produk.produksi.create', compact('produk', 'bahan'));
    }

    public function store(Request $request)
{
    $request->validate([
        'id_produk' => 'required|exists:produk,id_produk',
        'id_bahan.*' => 'required|exists:bahan,id_bahan',
        'jumlah_bahan.*' => 'required|numeric|min:0',
        'satuan.*' => 'required|string|max:10',
    ]);

    foreach ($request->id_bahan as $i => $bahanId) {
        $exists = ProdukBahan::where('id_produk', $request->id_produk)
            ->where('id_bahan', $bahanId)
            ->first();

        if ($exists) continue;

        ProdukBahan::create([
            'id_produk' => $request->id_produk,
            'id_bahan' => $bahanId,
            'jumlah_bahan' => $request->jumlah_bahan[$i],
            'satuan' => $request->satuan[$i],
        ]);
    }

    return redirect()->route('admin.produksi.item-produksi')
        ->with('success', 'Semua bahan berhasil ditambahkan!');
}


    public function edit($id)
    {
        $produkBahan = ProdukBahan::findOrFail($id);
        $produk = Produk::all();
        $bahan = Bahan::all();
        return view('admin.data-produk.produksi.edit', compact('produkBahan', 'produk', 'bahan'));
    }

    public function update(Request $request, $id)
{
    // Ambil data ProdukBahan berdasarkan ID yang dikirim di URL
    $produkBahanItem = ProdukBahan::findOrFail($id);

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

    return redirect()->route('admin.produksi.item-produksi')
        ->with('success', 'Data bahan berhasil diperbarui!');
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
    
        public function destroyAllBahan(Request $request)
    {
        $id_produk = $request->id_produk;

        ProdukBahan::where('id_produk', $id_produk)->delete();

        return back()->with('success', 'Semua bahan untuk produk berhasil dihapus!');
    }
}
