<?php

namespace App\Http\Controllers\Admin\Pembuatan;

use App\Http\Controllers\Controller;
use App\Models\JadwalProduksi;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class JadwalProduksiController extends Controller
{
    public function index(Request $request)
    {
        $penjadwalan = JadwalProduksi::with([
            'users',
            'pesanan',
            'jadwalUser'
        ])->get();

        return view('admin.data-produk.penjadwalan.read', compact('penjadwalan'));
    }

    public function create()
    {
        $pesanan = Pesanan::all();
        $users = User::where('role', 'karyawan')->get();

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

        $penjadwalan = JadwalProduksi::create([
            'id_pesanan'      => $request->id_pesanan,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status_jadwal'   => $request->status_jadwal,
        ]);

        foreach ($request->user_id as $index => $userId) {
            $penjadwalan->users()->attach($userId, [
                'upah' => $request->upah[$index],
            ]);
        }

        // Kirim notifikasi WA ke masing-masing karyawan
        foreach ($penjadwalan->users as $user) {
            if ($user->no_wa) {
                $pesan = "Halo {$user->name}, kamu ditugaskan untuk produksi pesanan dari tanggal " .
                         date('d M Y', strtotime($penjadwalan->tanggal_mulai)) . " sampai " .
                         date('d M Y', strtotime($penjadwalan->tanggal_selesai)) . ". Silakan cek sistem yaa 👨‍🍳";

                $this->kirimWhatsAppHideki($user->no_wa, $pesan);
            }
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

    private function kirimWhatsAppHideki($nomor, $pesan)
    {
        try {
            $response = Http::post('https://server-wagateway.hidekihoster.id/send-message', [
                'api_key' => env('WA_API_KEY', 'nw79GH7qBDNfPrhozJN5VNCxWDwU12OA'),
                'sender' => env('WA_SENDER', '6285117314151'),
                'number' => $nomor,
                'message' => $pesan,
            ]);

            if ($response->failed()) {
                logger()->error('Gagal kirim WA via Hideki:', [
                    'nomor' => $nomor,
                    'response' => $response->body()
                ]);
            }
        } catch (\Exception $e) {
            logger()->error('Exception kirim WA Hideki:', [
                'message' => $e->getMessage()
            ]);
        }
    }
}
