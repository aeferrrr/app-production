<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Produk;
use App\Models\Bahan;
use App\Models\Overhead;
use App\Models\Lokasi;

class AdminController extends Controller
{
    // Fitur Dashboard 
    public function index()
    {
        // Hitung jumlah total karyawan berdasarkan role
        $jumlahKaryawan = User::where('role', 'karyawan')->count();
        $jumlahProduk = Produk::count();
        $jumlahBahan = Bahan::count();
        $jumlahOverhead = Overhead::count();
        $jumlahLokasi = Lokasi::count();

        return view('admin.index', compact('jumlahKaryawan', 'jumlahProduk', 'jumlahBahan', 'jumlahOverhead', 'jumlahLokasi'));
    }

    // Menampilkan daftar Item Karyawan
    public function itemKaryawan(Request $request)
    {
        $user = User::query();
        if ($request->has('search')) {
            $user->where(function($query) use ($request) {
                $query->whereAny(['name', 'role', 'email'], 'LIKE', '%'.$request->input('search').'%');
            });
        }

        // Filter Berdasarkan Role
        if ($request->has('role') && in_array($request->input('role'), ['admin', 'karyawan'])) {
            $user->where('role', $request->input('role'));
        }

        // Paginasi
        $user = $user->paginate(5);
        return view('admin.data-master.pengguna.karyawan', compact('user', 'request'));
    }

    // Tampil form Karyawan
    public function create()
    {
        return view('admin.data-master.pengguna.karyawan-create');
    }

    // Simpan data Karyawan baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:64',
            'role' => 'required|in:admin,karyawan',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            // 'upah' => 'required|integer|min:0',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'role.required' => 'Jabatan wajib dipilih.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan, silakan pilih yang lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal harus 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            // 'upah.required' => 'Upah wajib diisi.',
            // 'upah.integer' => 'Upah harus berupa angka tanpa desimal.',
            // 'upah.min' => 'Upah tidak boleh negatif.',
        ]);

        User::create([
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            // 'upah' => $request->upah,
        ]);

        return redirect()->route('admin.item-karyawan')->with('success', 'Karyawan berhasil ditambahkan!');
    }

    // Tampil form Edit Karyawan
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.data-master.pengguna.karyawan-edit', compact('user'));
    }

    // Update data Karyawan
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,karyawan',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6',
            // 'upah' => 'required|integer|min:0',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'role.required' => 'Jabatan wajib dipilih.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan, silakan pilih yang lain.',
            'password.min' => 'Password minimal harus 6 karakter.',
            // 'upah.required' => 'Upah wajib diisi.',
            // 'upah.integer' => 'Upah harus berupa angka tanpa desimal.',
            // 'upah.min' => 'Upah tidak boleh negatif.',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->role = $request->role;
        $user->email = $request->email;
        // $user->upah = $request->upah;

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
