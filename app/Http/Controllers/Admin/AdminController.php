<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Produk;
use App\Models\Bahan;
use App\Models\Overhead;
use App\Models\Lokasi;
use App\Models\Pesanan;
use App\Models\JadwalProduksi;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    // Dashboard
    public function index()
    {
        $jumlahKaryawan = User::where('role', 'karyawan')->count();
        $jumlahProduk = Produk::count();
        $jumlahBahan = Bahan::count();
        $jumlahOverhead = Overhead::count();
        $jumlahLokasi = Lokasi::count();

        $totalPesananBulanIni = Pesanan::whereMonth('tanggal_pesanan', Carbon::now()->month)->count();
        $produksiSelesaiBulanIni = JadwalProduksi::where('status_jadwal', 'selesai')
            ->whereMonth('tanggal_mulai', Carbon::now()->month)->count();
        $totalUpahBulanIni = DB::table('jadwal_user')
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('upah');

        $jadwalHariIni = JadwalProduksi::with('pesanan', 'users')
            ->whereDate('tanggal_mulai', Carbon::today())
            ->get();

        // Tambahan grafik penjualan per bulan
        $penjualanPerBulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $penjualanPerBulan[] = [
                'bulan' => Carbon::create()->month($i)->translatedFormat('F'),
                'jumlah' => Pesanan::whereMonth('tanggal_pesanan', $i)
                    ->whereYear('tanggal_pesanan', Carbon::now()->year)
                    ->count()
            ];
        }

        return view('admin.index', compact(
            'jumlahKaryawan',
            'jumlahProduk',
            'jumlahBahan',
            'jumlahOverhead',
            'jumlahLokasi',
            'totalPesananBulanIni',
            'produksiSelesaiBulanIni',
            'totalUpahBulanIni',
            'jadwalHariIni',
            'penjualanPerBulan'
        ));
    }

    // List Karyawan
    public function itemKaryawan(Request $request)
    {
        $user = User::query();
        if ($request->has('search')) {
            $user->where(function($query) use ($request) {
                $query->whereAny(['name', 'role', 'email'], 'LIKE', '%'.$request->input('search').'%');
            });
        }

        if ($request->has('role') && in_array($request->input('role'), ['admin', 'karyawan'])) {
            $user->where('role', $request->input('role'));
        }

        $user = $user->paginate(5);
        return view('admin.data-master.pengguna.karyawan', compact('user', 'request'));
    }

    // Form Tambah Karyawan
    public function create()
    {
        return view('admin.data-master.pengguna.karyawan-create');
    }

    // Simpan Karyawan
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:64',
            'role' => 'required|in:admin,karyawan',
            'email' => 'required|email|unique:users,email',
            'no_wa' => 'required|string|max:20',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'role.required' => 'Jabatan wajib dipilih.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan.',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email,
            'no_wa' => $request->no_wa,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.item-karyawan')->with('success', 'Karyawan berhasil ditambahkan!');
    }

    // Form Edit Karyawan
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.data-master.pengguna.karyawan-edit', compact('user'));
    }

    // Update Karyawan
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,karyawan',
            'email' => 'required|email|unique:users,email,' . $id,
            'no_wa' => 'required|string|max:20',
            'password' => 'nullable|min:6',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'role.required' => 'Jabatan wajib dipilih.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan.',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->role = $request->role;
        $user->email = $request->email;
        $user->no_wa = $request->no_wa;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('admin.item-karyawan')->with('success', 'Data karyawan berhasil diperbarui!');
    }

    // Hapus Karyawan
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.item-karyawan')->with('success', 'Pengguna berhasil dihapus!');
    }
}
