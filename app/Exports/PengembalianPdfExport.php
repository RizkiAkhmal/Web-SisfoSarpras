<?php

namespace App\Exports;

use App\Models\Pengembalian;
use Barryvdh\DomPDF\Facade\Pdf;

class PengembalianPdfExport
{
    public function download()
    {
        $pengembalians = Pengembalian::with(['peminjaman', 'peminjaman.barang'])->get();
        $pdf = PDF::loadView('admin.laporan.pdf.pengembalian', compact('pengembalians'));
        return $pdf->download('laporan-pengembalian.pdf');
    }
}