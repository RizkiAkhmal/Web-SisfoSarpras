<?php

namespace App\Http\Controllers\admin;

use App\Exports\BarangExport;
use App\Exports\BarangPdfExport;
use App\Exports\PeminjamanExport;
use App\Exports\PeminjamanPdfExport;
use App\Exports\PengembalianExport;
use App\Exports\PengembalianPdfExport;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request) {
        $query = Barang::query();
        
        // Handle searchbar
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhereHas('kategoris', function($q) use ($search) {
                      $q->where('nama_kategori', 'like', "%{$search}%");
                  });
            });
        }
        
        $barangs = $query->get();
        return view('admin.laporan.barang', compact('barangs'));
    }

    public function peminjaman(Request $request){
        $query = Peminjaman::with(['user', 'barang']);
        
        // Handle searchbar
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('barang', function($q) use ($search) {
                      $q->where('nama_barang', 'like', "%{$search}%");
                  })
                  ->orWhere('alasan_pinjam', 'like', "%{$search}%");
            });
        }
        
        $peminjamans = $query->get();
        return view('admin.laporan.peminjaman', compact('peminjamans')); 
    }

    public function pengembalian(Request $request){
        $query = Pengembalian::with(['peminjaman', 'peminjaman.barang', 'peminjaman.user']);
        
        // Handle searchbar
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('peminjaman.user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('peminjaman.barang', function($q) use ($search) {
                      $q->where('nama_barang', 'like', "%{$search}%");
                  })
                  ->orWhere('kondisi', 'like', "%{$search}%");
            });
        }
        
        $pengembalians = $query->get();
        return view('admin.laporan.pengembalian', compact('pengembalians'));
    }
    
    public function exportBarang() 
    {
        return Excel::download(new BarangExport, 'laporan-barang.xlsx');
    }
    
    public function exportPeminjaman() 
    {
        return Excel::download(new PeminjamanExport, 'laporan-peminjaman.xlsx');
    }
    
    public function exportPengembalian() 
    {
        return Excel::download(new PengembalianExport, 'laporan-pengembalian.xlsx');
    }
    
    public function exportBarangPdf()
    {
        $barangs = Barang::with('kategoris')->get();
        $pdf = PDF::loadView('admin.laporan.pdf.barang', compact('barangs'));
        return $pdf->download('laporan-barang.pdf');
    }
    
    public function exportPeminjamanPdf()
    {
        $peminjamans = Peminjaman::with(['user', 'barang'])->get();
        $pdf = PDF::loadView('admin.laporan.pdf.peminjaman', compact('peminjamans'));
        return $pdf->download('laporan-peminjaman.pdf');
    }
    
    public function exportPengembalianPdf()
    {
        $pengembalians = Pengembalian::with(['peminjaman', 'peminjaman.barang'])->get();
        $pdf = PDF::loadView('admin.laporan.pdf.pengembalian', compact('pengembalians'));
        return $pdf->download('laporan-pengembalian.pdf');
    }
}




