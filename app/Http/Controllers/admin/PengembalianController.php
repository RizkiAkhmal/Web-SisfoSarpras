<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengembalian;
use App\Models\Peminjaman;

class PengembalianController extends Controller
{
    /**
     * Tampilkan daftar pengembalian ke admin tanpa filter dan search.
     */
    public function index()
    {
        $pengembalians = Pengembalian::with(['peminjaman', 'peminjaman.barang'])
            ->latest()
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

        if (method_exists($pengembalian, 'hitungKeterlambatan')) {
            $pengembalian->hitungKeterlambatan();
        }

        $pengembalian->update(['status' => 'complete']);

        $peminjaman = $pengembalian->peminjaman;
        $peminjaman->update(['status' => 'returned']);

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

        $pengembalian->update(['status' => 'damage']);

        $peminjaman = $pengembalian->peminjaman;
        $peminjaman->update(['status' => 'rejected']);

        $barang = $peminjaman->barang;
        if ($barang) {
            $barang->decrement('jumlah_barang', $pengembalian->jumlah_kembali);
        }

        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian barang rusak berhasil ditandai.');
    }

    /**
     * Menampilkan form input denda untuk pengembalian rusak.
     */
    public function markDamaged($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        return view('admin.pengembalian.markDamaged', compact('pengembalian'));
    }

    /**
     * Menyimpan denda untuk pengembalian rusak.
     */
    public function updateDamaged(Request $request, $id)
    {
        $validated = $request->validate([
            'denda' => 'required|numeric|min:0',
        ]);

        $pengembalian = Pengembalian::findOrFail($id);

        $pengembalian->update([
            'status' => 'damage',
            'biaya_denda' => $validated['denda'],
        ]);

        $peminjaman = $pengembalian->peminjaman;
        $peminjaman->update(['status' => 'rejected']);

        $barang = $peminjaman->barang;
        if ($barang) {
            $barang->increment('jumlah_barang', $pengembalian->jumlah_kembali);
        }

        return redirect()->route('pengembalian.index')->with('success', 'Denda pengembalian rusak berhasil diperbarui.');
    }
}
