<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total barang (stok tersedia + dipinjam)
        $totalBarang = Barang::sum('jumlah_barang');

        // Total barang yang sedang dipinjam (status approved dan belum dikembalikan)
        $totalDipinjam = Peminjaman::where('status', 'approved')
            ->whereNotIn('id', function($query) {
                $query->select('id_peminjaman')
                    ->from('pengembalians')
                    ->where('status', 'complete');
            })
            ->sum('jumlah');

        // Total peminjam (unique users yang memiliki peminjaman aktif)
        $totalPeminjam = Peminjaman::where('status', 'approved')
            ->whereNotIn('id', function($query) {
                $query->select('id_peminjaman')
                    ->from('pengembalians')
                    ->where('status', 'complete');
            })
            ->select('id_user')
            ->distinct()
            ->count();

        // Total pending approval (peminjaman yang belum disetujui)
        $totalPending = Peminjaman::where('status', 'pending')->count();

        // Total barang rusak (dari pengembalian dengan status damage)
        $totalRusak = Pengembalian::where('status', 'damage')
            ->sum('jumlah_kembali');

        // Total yang sudah dikembalikan dengan baik (status complete)
        $totalDikembalikan = Pengembalian::where('status', 'complete')
            ->where('kondisi', 'baik')
            ->count();

        // Total yang belum dikembalikan (peminjaman approved tanpa pengembalian complete)
        $totalBelumDikembalikan = Peminjaman::where('status', 'approved')
            ->whereNotIn('id', function($query) {
                $query->select('id_peminjaman')
                    ->from('pengembalians')
                    ->where('status', 'complete');
            })
            ->count();

        // Hitung persentase untuk progress bars
        $persentaseDipinjam = $totalBarang > 0 ? ($totalDipinjam / $totalBarang * 100) : 0;
        $persentasePending = $totalDipinjam > 0 ? ($totalPending / $totalDipinjam * 100) : 0;

        return view('admin.dashboard', compact(
            'totalBarang',
            'totalDipinjam',
            'totalPeminjam',
            'totalPending',
            'totalRusak',
            'totalDikembalikan',
            'totalBelumDikembalikan',
            'persentaseDipinjam',
            'persentasePending'
        ));
    }
}
