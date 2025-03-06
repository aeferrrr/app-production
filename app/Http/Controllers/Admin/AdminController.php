<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    // Menampilkan daftar Item Karyawan
    public function itemKaryawan(Request $request)
    {
        $pengguna = User::query();
        if ($request->has('search')) {
            $pengguna->where(function($query)use($request){
                $query->whereAny(['name', 'role', 'email'], 'LIKE', '%'.$request->input('search').'%');
            });
        }

        // Filter Berdasarkan Role (Admin / Karyawan)
        if ($request->has('role') && in_array($request->input('role'), ['admin', 'karyawan'])) {
            $pengguna->where('role', $request->input('role'));
        }
        $pengguna = $pengguna->paginate(5);
        return view('admin.data-master.karyawan', compact('pengguna', 'request'));
    }
}
