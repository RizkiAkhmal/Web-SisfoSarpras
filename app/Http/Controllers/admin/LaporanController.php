<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index() {
        $barangs = Barang::all();
        return view('admin.laporan.barang', compact('barangs'));
    }

    public function peminjaman(){
        $peminjamans = Peminjaman::all();
        return view('admin.laporan.peminjaman', compact('peminjamans')); 
    }
}
