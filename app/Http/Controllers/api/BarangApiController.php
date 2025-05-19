<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;

class BarangApiController extends Controller
{
    public function index()
    {
        $barangs = Barang::with('kategoris')->get();

        $formatted = $barangs->map(function ($barang) {
            return [
                'id' => $barang->id,
                'nama_barang' => $barang->nama_barang,
                'jumlah_barang' => $barang->jumlah_barang,
                'id_kategori' => $barang->id_kategori,
                'foto' => url('storage/' . $barang->foto), // tampilkan URL lengkap foto
                'kategori' => [
                    'id' => $barang->kategoris->id,
                    'nama_kategori' => $barang->kategoris->nama_kategori,
                ]
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formatted
        ]);
    }
}
