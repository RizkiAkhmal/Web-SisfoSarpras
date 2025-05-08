<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index() {
        $peminjamans = Peminjaman::with('user', 'barang')->get();
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function show($id){
        $peminjaman = Peminjaman::with('user', 'barang')->findOrFail($id);
        return view('admin.peminjaman.show', compact('peminjamans'));
    }

    public function approve($id){
        $peminjaman = Peminjaman::findOrFail($id);
        $barang = $peminjaman->barang;

        if ($barang->jumlah_barang < $peminjaman->jumlah) {
            return redirect()->back()->with('error', 'Stok barang tidak mencukupi.');
        }

        $barang->jumlah_barang -= $peminjaman->jumlah;
        $barang->save();

        $peminjaman->status = 'approved';
        $peminjaman->save();

        return redirect()->back()->with('success', 'Peminjaman disetujui.');
    }

    public function reject($id){
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status = 'rejected';
        $peminjaman->save();

        return redirect()->back()->with('success', 'Peminjaman ditolak.');
    }

    public function destroy($id) {
        Peminjaman::findOrFail($id)->delete();
        return redirect()->route('kategori.index')->with('success', 'Peminjaman berhasil dihapus.');
    }

    
    
}
