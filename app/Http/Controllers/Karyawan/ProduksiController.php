<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalProduksi;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProduksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $query = JadwalProduksi::with(['pesanan', 'users']);

    if ($request->has('search') && $request->search != '') {
        $query->whereHas('pesanan', function ($q) use ($request) {
            $q->where('kode_pesanan', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->has('status') && $request->status != '') {
        $query->where('status_jadwal', $request->status);
    }

    $penjadwalan = $query->latest()->paginate(5)->withQueryString();

    return view('karyawan.produksi.read', compact('penjadwalan'));
}

public function updateCatatan(Request $request, $id)
{
    try {
        $request->validate([
            'catatan' => 'nullable|string|max:255'
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->catatan = $request->catatan;
        $pesanan->save();

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

public function karyawanUpdateStatus(Request $request, $id)
{
    try {
        $request->validate([
            'status' => 'required|string',
        ]);

        $jadwal = JadwalProduksi::findOrFail($id);
        $jadwal->status_jadwal = $request->status;
        $jadwal->save();

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}



}
