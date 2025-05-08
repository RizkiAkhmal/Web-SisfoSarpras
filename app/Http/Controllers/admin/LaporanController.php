<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index() {
        $barangs = Barang::all();
        return view('admin.laporan.barang', compact('barangs'));
    }
}
