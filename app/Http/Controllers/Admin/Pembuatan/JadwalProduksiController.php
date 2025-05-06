<?php

namespace App\Http\Controllers\Admin\Pembuatan;

use App\Http\Controllers\Controller;
use App\Models\JadwalProduksi;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JadwalProduksiController extends Controller
{
 //menampilkan daftar penjadwalan

    public function index(Request $request)
    {
        // Ambil data Penjadwalan beserta relasi dengan JadwalUser dan User
        $penjadwalan = JadwalProduksi::with([
            'users',
            'pesanan',
            'jadwalUser' // cukup ini aja, karena udah relasi ke User langsung
        ])->get();
        
    
        // Tampilkan hasilnya
        return view('admin.data-produk.penjadwalan.read', compact('penjadwalan'));
    }
    public function create()
    {
        $pesanan = Pesanan::all(); // Ambil semua pesanan
        $users = User::where('role', 'karyawan')->get(); // Ambil hanya user yang role-nya karyawan
    
        return view('admin.data-produk.penjadwalan.create', compact('pesanan', 'users'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'id_pesanan'        => 'required|exists:pesanan,id_pesanan',
            'tanggal_mulai'     => 'required|date',
            'tanggal_selesai'   => 'required|date|after_or_equal:tanggal_mulai',
            'status_jadwal'     => 'required|in:menunggu,berjalan,selesai',
            'user_id.*'         => 'required|exists:users,id',
            'upah.*'            => 'required|numeric|min:0',
        ]);

        // Simpan penjadwalan produksi
        $penjadwalan = JadwalProduksi::create([
            'id_pesanan'      => $request->id_pesanan,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status_jadwal'   => $request->status_jadwal,
        ]);

        // Simpan relasi ke user (petugas) + upah lewat tabel pivot
        foreach ($request->user_id as $index => $userId) {
            $penjadwalan->users()->attach($userId, [
                'upah' => $request->upah[$index],
            ]);
        }

        return redirect()->route('admin.produksi.item-penjadwalan')->with('success', 'Penjadwalan berhasil dibuat.');
    }
    public function edit($id)
    {
        $jadwal = JadwalProduksi::with('users')->findOrFail($id);
        $pesanan = Pesanan::all();
        $users = User::where('role', 'karyawan')->get();

        return view('admin.data-produk.penjadwalan.edit', compact('jadwal', 'pesanan', 'users'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'id_pesanan'        => 'required|exists:pesanan,id_pesanan',
            'tanggal_mulai'     => 'required|date',
            'tanggal_selesai'   => 'required|date|after_or_equal:tanggal_mulai',
            'status_jadwal'     => 'required|in:menunggu,berjalan,selesai',
            'user_id.*'         => 'required|exists:users,id',
            'upah.*'            => 'required|numeric|min:0',
        ]);

        $jadwal = JadwalProduksi::findOrFail($id);

        $jadwal->update([
            'id_pesanan'      => $request->id_pesanan,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status_jadwal'   => $request->status_jadwal,
        ]);

        // Sinkronisasi user dan upah
        $syncData = [];
        foreach ($request->user_id as $index => $userId) {
            $syncData[$userId] = ['upah' => $request->upah[$index]];
        }

        $jadwal->users()->sync($syncData);

        return redirect()->route('admin.produksi.item-penjadwalan')->with('success', 'Penjadwalan berhasil diupdate.');
    }
    public function destroy($id)
    {
        JadwalProduksi::destroy($id);
        return redirect()->route('admin.produksi.item-penjadwalan')->with('success', 'Pesanan berhasil dihapus.');
    }
}