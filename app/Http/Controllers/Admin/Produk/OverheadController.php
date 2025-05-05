<?php

namespace App\Http\Controllers\Admin\Produk;

use App\Http\Controllers\Controller;
use App\Models\Overhead;
use Illuminate\Http\Request;

class OverheadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bop = Overhead::paginate(5);
        return view('admin.data-master.overhead-item.read', compact('bop'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.data-master.overhead-item.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_bop' => 'required|string|max:25',
            'biaya_bop' => 'required|integer|min:0',
            'keterangan_bop' => 'required|string|max:255',
        ], [
            'nama_bop.required' => 'Nama Overhead Wajib diisi',
            'biaya_bop.required' => 'Biaya wajib diisi.',
            'biaya_bop.integer' => 'Biaya harus berupa angka tanpa desimal.',
            'biaya_bop.min' => 'Biaya tidak boleh negatif.',
        ]);
        Overhead::create([
            'nama_bop' => $request->nama_bop,
            'biaya_bop' => $request->biaya_bop,
            'keterangan_bop' => $request->keterangan_bop,
        ]);

        return redirect()->route('admin.overhead.item-overhead')->with('success', 'Overhead berhasil ditambahkan!');
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
        $overhead = Overhead::findOrFail($id);
        return view('admin.data-master.overhead-item.edit', compact('overhead'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_bop' => 'required|string|max:25',
            'biaya_bop' => 'required|integer|min:0',
            'keterangan_bop' => 'required|string|max:255',
        ], [
            'nama_bop.required' => 'Nama Overhead Wajib diisi',
            'biaya_bop.required' => 'Biaya wajib diisi.',
            'biaya_bop.integer' => 'Biaya harus berupa angka tanpa desimal.',
            'biaya_bop.min' => 'Biaya tidak boleh negatif.',
        ]);
    
        $bop = Overhead::findOrFail($id);
        $bop->update([
            'nama_bop' => $request->nama_bop,
            'biaya_bop' => $request->biaya_bop,
            'keterangan_bop' => $request->keterangan_bop,
        ]);
    
        return redirect()->route('admin.overhead.item-overhead')->with('success', 'Overhead berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bop = Overhead::findOrFail($id);
        $bop->delete();

        return redirect()->route('admin.overhead.item-overhead')->with('success', 'Overhead berhasil dihapus!');
    }
}
