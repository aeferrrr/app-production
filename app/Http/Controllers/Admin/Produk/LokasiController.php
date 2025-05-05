<?php

namespace App\Http\Controllers\Admin\Produk;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lokasi = Lokasi::paginate(5);
        return view('admin.data-master.lokasi-item.read', compact('lokasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.data-master.lokasi-item.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:100',
        ], [
            'nama_lokasi.required' => 'Nama lokasi wajib diisi.',
        ]);

        Lokasi::create([
            'nama_lokasi' => $request->nama_lokasi,
        ]);

        return redirect()->route('admin.lokasi.item-lokasi')->with('success', 'Lokasi berhasil ditambahkan!');
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
    public function edit($id)
    {
        $lokasi = Lokasi::findOrFail($id);
        return view('admin.data-master.lokasi-item.edit', compact('lokasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:100',
        ], [
            'nama_lokasi.required' => 'Nama lokasi wajib diisi.',
        ]);

        $lokasi = Lokasi::findOrFail($id);
        $lokasi->update([
            'nama_lokasi' => $request->nama_lokasi,
        ]);

        return redirect()->route('admin.lokasi.item-lokasi')->with('success', 'Lokasi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lokasi = Lokasi::findOrFail($id);
        $lokasi->delete();

        return redirect()->route('admin.lokasi.item-lokasi')->with('success', 'Lokasi berhasil dihapus!');
    }
}
