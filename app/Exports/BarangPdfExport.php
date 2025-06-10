<?php

namespace App\Exports;

use App\Models\Barang;
use Illuminate\Contracts\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

class BarangPdfExport
{
    public function download()
    {
        $barangs = Barang::with('kategoris')->get();
        $pdf = PDF::loadView('admin.laporan.pdf.barang', compact('barangs'));
        return $pdf->download('laporan-barang.pdf');
    }
}
