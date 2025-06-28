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

    // Filter by keyword
    if ($request->filled('search')) {
        $pesananQuery->where(function ($query) use ($request) {
            $query->where('kode_pesanan', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('nama_pemesan', 'LIKE', '%' . $request->search . '%');
        });
    }

    // Filter by tanggal pemesanan
    if ($request->filled('tanggal_mulai')) {
        $pesananQuery->whereDate('tanggal_pesanan', '>=', $request->tanggal_mulai);
    }

    if ($request->filled('tanggal_selesai')) {
        $pesananQuery->whereDate('tanggal_pesanan', '<=', $request->tanggal_selesai);
    }

    // Ambil semua hasil yang cocok
    $pesanan = $pesananQuery->with('detailPesanan.produk')->get();

    return view('admin.data-produk.pesanan.read', compact('pesanan'));
}

    private function generateKodePesanan()
{
    $last = \App\Models\Pesanan::orderBy('id_pesanan', 'desc')->first();
    $nextId = $last ? ((int)substr($last->kode_pesanan, 3)) + 1 : 1;
    return 'PSN' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
}


    /**
     * Menampilkan form tambah pesanan.
     */
    public function create()
    {
        $kode_pesanan = $this->generateKodePesanan();
        $produk = Produk::all();
        return view('admin.data-produk.pesanan.create', compact('produk'));
    }

    /**
     * Menyimpan pesanan baru ke database.
     */
    public function store(Request $request)
    { 
        $request->validate([
        'kode_pesanan'     => 'unique:pesanan,kode_pesanan|max:10',
        'tanggal_pesanan'  => 'required|date',
        'nama_pemesan'     => 'required|string|max:32',
        'produk_id.*'      => 'required|exists:produk,id_produk',
        'jumlah.*'         => 'required|integer|min:1',
    ], [
        'kode_pesanan.unique'      => 'Kode pesanan sudah terdaftar, gunakan yang lain.',
        'kode_pesanan.max'         => 'Kode pesanan maksimal 6 karakter.',
        'tanggal_pesanan.required' => 'Tanggal pemesanan wajib diisi.',
        'tanggal_pesanan.date'     => 'Format tanggal tidak valid.',
        'nama_pemesan.required'    => 'Nama pemesan wajib diisi.',
        'nama_pemesan.string'      => 'Nama pemesan harus berupa teks.',
        'nama_pemesan.max'         => 'Nama pemesan melebihi maksimal.',
        'produk_id.*.required'     => 'Setiap produk yang dipilih wajib diisi.',
        'produk_id.*.exists'       => 'Produk yang dipilih tidak valid atau sudah dihapus.',
        'jumlah.*.required'        => 'Jumlah produk wajib diisi.',
        'jumlah.*.integer'         => 'Jumlah produk harus berupa angka.',
        'jumlah.*.min'             => 'Jumlah minimal adalah 1.',
    ]);

    $kodePesanan = $this->generateKodePesanan();

        // Simpan data pesanan
        $pesanan = Pesanan::create([
            'kode_pesanan'     => $kodePesanan,
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
        'kode_pesanan'     => 'required|unique:pesanan,kode_pesanan,' . $pesanan->id_pesanan . ',id_pesanan|max:6',
        'tanggal_pesanan'  => 'required|date',
        'nama_pemesan'     => 'required|string|max:32',
        'produk_id.*'      => 'required|exists:produk,id_produk',
        'jumlah.*'         => 'required|integer|min:1',
    ], [
        'kode_pesanan.required'    => 'Kode pesanan wajib diisi.',
        'kode_pesanan.unique'      => 'Kode pesanan sudah digunakan. Silakan gunakan kode yang lain.',
        'kode_pesanan.max'         => 'Kode pesanan maksimal terdiri dari 6 karakter.',
        'tanggal_pesanan.required' => 'Tanggal pemesanan wajib diisi.',
        'tanggal_pesanan.date'     => 'Format tanggal pemesanan tidak valid.',
        'nama_pemesan.required'    => 'Nama pemesan wajib diisi.',
        'nama_pemesan.string'      => 'Nama pemesan harus berupa teks.',
        'nama_pemesan.max'         => 'Nama pemesan melebihi maksimal.',
        'produk_id.*.required'     => 'Setiap produk yang dipilih wajib diisi.',
        'produk_id.*.exists'       => 'Produk yang dipilih tidak ditemukan atau sudah dihapus.',
        'jumlah.*.required'        => 'Jumlah produk wajib diisi.',
        'jumlah.*.integer'         => 'Jumlah produk harus berupa angka.',
        'jumlah.*.min'             => 'Jumlah produk minimal adalah 1.',
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
