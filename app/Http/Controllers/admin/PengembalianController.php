<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengembalian;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    /**
     * Tampilkan daftar pengembalian ke admin tanpa filter dan search.
     */
    public function index()
    {
        $pengembalians = Pengembalian::with(['peminjaman', 'peminjaman.barang', 'peminjaman.user'])
            ->get();


        return view('admin.pengembalian.index', compact('pengembalians'));
    }

    /**
     * Menyetujui pengembalian (status 'complete').
     */
    public function approve($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        if ($pengembalian->status === 'complete') {
            return redirect()->route('pengembalian.index')->with('error', 'Pengembalian ini sudah diselesaikan.');
        }

        // Hitung denda keterlambatan
        $infoDenda = $this->hitungInfoDenda($pengembalian);
        
        // Update pengembalian dengan denda keterlambatan
        $pengembalian->update([
            'status' => 'complete',
            'hari_terlambat' => $infoDenda['hari_terlambat'],
            'denda_keterlambatan' => $infoDenda['denda_keterlambatan'],
            'biaya_denda' => $infoDenda['denda_keterlambatan'] // Total denda = denda keterlambatan
        ]);

        // Update status peminjaman menjadi 'returned' setelah pengembalian disetujui
        $peminjaman = $pengembalian->peminjaman;
        $peminjaman->update(['status' => 'returned']);

        // Kembalikan stok barang
        $barang = $peminjaman->barang;
        if ($barang) {
            $barang->increment('jumlah_barang', $pengembalian->jumlah_kembali);
        }

        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil disetujui.');
    }

    
    /**
     * Menandai pengembalian sebagai rusak (status 'damage').
     */
    public function reject($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        return redirect()->route('pengembalian.markDamaged', $pengembalian->id);
    }

    /**
     * Menampilkan form input denda untuk pengembalian rusak.
     */
    public function markDamaged($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        
        // Hitung denda keterlambatan untuk ditampilkan di form
        $pengembalian->setAttribute('infoDenda', $this->hitungInfoDenda($pengembalian));
        
        return view('admin.pengembalian.markDamaged', compact('pengembalian'));
    }

    /**
     * Menyimpan denda untuk pengembalian rusak.
     */
    public function updateDamaged(Request $request, $id)
    {
        $validated = $request->validate([
            'denda' => 'required|numeric|min:0|max:10000000', // Allow up to 10 million
        ]);

        $pengembalian = Pengembalian::findOrFail($id);

        // Hitung denda keterlambatan
        $infoDenda = $this->hitungInfoDenda($pengembalian);
        
        // Update pengembalian dengan denda kerusakan dan keterlambatan
        $dendaKerusakan = $validated['denda'];
        $totalDenda = $infoDenda['denda_keterlambatan'] + $dendaKerusakan;
        
        $pengembalian->update([
            'status' => 'damage',
            'kondisi' => 'rusak',
            'hari_terlambat' => $infoDenda['hari_terlambat'],
            'denda_keterlambatan' => $infoDenda['denda_keterlambatan'],
            'denda_kerusakan' => $dendaKerusakan,
            'biaya_denda' => $totalDenda
        ]);

        $peminjaman = $pengembalian->peminjaman;
        $peminjaman->update(['status' => 'returned']);

        // Kembalikan stok barang hanya jika kondisi tidak hilang
        $barang = $peminjaman->barang;
        if ($barang && $pengembalian->kondisi !== 'hilang') {
            $barang->increment('jumlah_barang', $pengembalian->jumlah_kembali);
        }

        return redirect()->route('pengembalian.index')->with('success', 'Denda pengembalian rusak berhasil diperbarui.');
    }


public function hitungInfoDenda(Pengembalian $pengembalian)
{
    $hariTerlambat = 0;
    $dendaKeterlambatan = 0;
    
    if ($pengembalian->peminjaman) {
        $tanggalHarusKembali = \Carbon\Carbon::parse($pengembalian->peminjaman->tgl_kembali);
        $tanggalDikembalikan = \Carbon\Carbon::parse($pengembalian->tgl_kembali);

        $hariTerlambat = $tanggalDikembalikan->greaterThan($tanggalHarusKembali) 
            ? $tanggalDikembalikan->diffInDays($tanggalHarusKembali) 
            : 0;

        if ($hariTerlambat > 0) {
            $tarifDenda = 50000;
            $dendaKeterlambatan = $hariTerlambat * $tarifDenda; 
        }
    }

    return [
        'hari_terlambat' => $hariTerlambat,
        'denda_keterlambatan' => $dendaKeterlambatan,
    ];
}

}


