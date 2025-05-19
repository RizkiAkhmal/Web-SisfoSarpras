<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanApiController extends Controller
{
    public function store(Request $request){
        $validated = $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_barang' => 'required|exists:barangs,id',
            // 'nama_peminjam' => 'required|string',
            'alasan_pinjam' => 'required|string',
            'jumlah' => 'required|integer',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date',
            'status' => 'in:pending,approved,rejected,returned',
        ]);
    
        $peminjaman = Peminjaman::create($validated);
        $peminjaman->load(['barang', 'user']);
    
        return response()->json([       
            'message' => 'Peminjaman berhasil ditambahkan',
            'data' => [
                'id' => $peminjaman->id,
                // 'nama_peminjam' => $peminjaman->nama_peminjam,
                'alasan_pinjam' => $peminjaman->alasan_pinjam,
                'jumlah' => $peminjaman->jumlah,
                'tgl_pinjam' => $peminjaman->tgl_pinjam,
                'tgl_kembali' => $peminjaman->tgl_kembali,
                'status' => $peminjaman->status,
                'barang' => [
                    'id' => $peminjaman->barang->id,
                    'nama' => $peminjaman->barang->nama_barang
                ]
            ]
        ], 201);
    }

    public function getByUser(Request $request){
    $user = $request->user(); // Ambil user dari token Sanctum

    $peminjaman = Peminjaman::with(['barang']) // pastikan relasi barang() sudah dibuat
        ->where('id_user', $user->id)
        ->orderBy('created_at', 'desc')
        ->get();

    return response()->json([
        'message' => 'Data peminjaman user berhasil dimuat',
        'data' => $peminjaman,
     ]);
    }

    public function index()
    {
        $peminjamans = Peminjaman::with(['barang'])->get();
        return response()->json([
            'success' => true,
            'data' => $peminjamans
        ]);
    }
}

    

