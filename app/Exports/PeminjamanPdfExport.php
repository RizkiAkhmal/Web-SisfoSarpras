<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;

class PeminjamanPdfExport
{
    public function download()
    {
        $peminjamans = Peminjaman::with(['user', 'barang'])->get();
        $pdf = PDF::loadView('admin.laporan.pdf.peminjaman', compact('peminjamans'));
        return $pdf->download('laporan-peminjaman.pdf');
    }
}