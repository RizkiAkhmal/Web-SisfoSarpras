<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    // Tampilkan daftar semua pengembalian
    public function index()
    {
        $pengembalians = Pengembalian::with('peminjaman')->get();
        return view('admin.pengembalian.index', compact('pengembalians'));
    }

    // Setujui pengembalian
    public function approve($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        if ($pengembalian->status === 'complete') {
            return redirect()->route('admin.pengembalian.index')
                ->with('error', 'Pengembalian sudah diselesaikan.');
        }

        $pengembalian->update(['status' => 'complete']);

        $peminjaman = $pengembalian->peminjaman;
        $peminjaman->update(['status' => 'returned']);

        $barang = $peminjaman->barang;
        if ($barang) {
            $barang->increment('stok', $pengembalian->jumlah_kembali);
        }

        return redirect()->route('admin.pengembalian.index')
            ->with('success', 'Pengembalian disetujui.');
    }

    // Tolak pengembalian (barang rusak)
    public function reject($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        $peminjaman = $pengembalian->peminjaman;
        $peminjaman->update(['status' => 'rejected']);

        $barang = $peminjaman->barang;
        if ($barang) {
            $barang->decrement('stok', $pengembalian->jumlah_kembali);
        }

        return redirect()->route('admin.pengembalian.index')
            ->with('success', 'Barang rusak berhasil ditandai.');
    }

    // Tampilkan form pengembalian rusak
    public function damaged($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        return view('admin.pengembalian.damaged', compact('pengembalian'));
    }

    // Update status kerusakan dan denda
    public function updateDamage(Request $request, $id)
    {
        $validated = $request->validate([
            'denda' => 'required|numeric|min:0',
        ]);

        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->update([
            'status' => 'damage',
            'denda' => $validated['denda'],
        ]);

        $peminjaman = $pengembalian->peminjaman;
        $peminjaman->update(['status' => 'rejected']);

        $barang = $peminjaman->barang;
        if ($barang) {
            $barang->increment('stok', $pengembalian->jumlah_dikembalikan);
        }

        return redirect()->route('admin.pengembalian.index')
            ->with('success', 'Denda pengembalian rusak berhasil diperbarui.');
    }

}
