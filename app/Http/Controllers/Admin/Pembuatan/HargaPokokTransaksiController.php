<?php

namespace App\Http\Controllers\Admin\Pembuatan;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class HargaPokokTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $produk = Produk::all();
        $selectedProduct = null;
        $jumlah = null;
        $hppData = null;

        if ($request->has('produk_id') && $request->produk_id != '') {
            $selectedProduct = Produk::with('produkBahan.bahan')->findOrFail($request->produk_id);
            $jumlah = (int) $request->jumlah ?? 0;
            $totalBTK = (int) $request->btk ?? 0; // BTK total untuk seluruh produksi
            $totalBOP = (int) $request->bop ?? 0; // BOP total untuk seluruh produksi

            $hppData = $this->calculateHpp($selectedProduct, $jumlah, $totalBTK, $totalBOP);
        }

        return view('admin.data-produk.hpp.index', compact('produk', 'selectedProduct', 'jumlah', 'hppData'));
    }

    private function calculateHpp($produk, $quantity, $totalBTK, $totalBOP)
    {
        $bahan = [];
        $totalBBB = 0;

        foreach ($produk->produkBahan as $pb) {
            $jumlahBahan = $pb->jumlah_bahan * $quantity;
            $hargaBahan = $pb->bahan->harga_bahan;
            $subtotal = $jumlahBahan * $hargaBahan;

            $bahan[] = [
                'id' => $pb->bahan->id_bahan,
                'kode' => $pb->bahan->kode_bahan,
                'nama' => $pb->bahan->nama_bahan,
                'jumlah' => $jumlahBahan,
                'satuan' => $pb->satuan,
                'harga' => $hargaBahan,
                'subtotal' => $subtotal,
            ];

            $totalBBB += $subtotal;
        }

        $totalHPP = $totalBBB + $totalBTK + $totalBOP;
        $hppPerUnit = $quantity > 0 ? $totalHPP / $quantity : 0;

        return [
            'bahan' => $bahan,
            'totalBBB' => $totalBBB,
            'totalBTK' => $totalBTK,
            'totalBOP' => $totalBOP,
            'totalHPP' => $totalHPP,
            'hppPerUnit' => $hppPerUnit,
            'jumlah' => $quantity,
        ];
    }
}
