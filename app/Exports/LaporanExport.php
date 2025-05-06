<?php

namespace App\Exports;

use App\Models\JadwalProduksi;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class LaporanExport implements FromView
{
    protected $laporan;

    public function __construct($laporan)
    {
        $this->laporan = $laporan;
    }

    public function view(): View
    {
        return view('admin.data-transaksi.laporan-transaksi.excel', [
            'laporan' => $this->laporan
        ]);
    }
}
