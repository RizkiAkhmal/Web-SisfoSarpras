<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class PengembalianApiController extends Controller
{
     // Menyimpan data pengembalian
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pengembali'   => 'required|string|max:255',
            'id_peminjaman'     => 'required|exists:peminjamans,id',
            'tgl_kembali'       => 'required|date',
            'jumlah_kembali'    => 'required|integer|min:1',
            'status'            => 'required|in:pending,complete,damage',
            'kondisi'           => 'required|string|max:255',
            'biaya_denda'       => 'nullable|numeric|min:0',
        ]);

        // Temukan peminjaman berdasarkan ID
        $peminjaman = Peminjaman::with('barang')->findOrFail($validated['id_peminjaman']);

        // Cek apakah peminjaman sudah dikembalikan
        if ($peminjaman->status === 'returned') {
            return response()->json([
                'success' => false,
                'message' => 'Barang dari peminjaman ini sudah dikembalikan.'
            ], 400);
        }

        // Cek apakah peminjaman sudah disetujui admin
        if ($peminjaman->status !== 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman ini belum disetujui oleh admin.'
            ], 400);
        }

        // Simpan pengembalian
        $pengembalian = Pengembalian::create([
            'nama_pengembali' => $validated['nama_pengembali'],
            'id_peminjaman'   => $validated['id_peminjaman'],
            'tgl_kembali'     => $validated['tgl_kembali'],
            'jumlah_kembali'  => $validated['jumlah_kembali'],
            'status'          => $validated['status'],
            'kondisi'         => $validated['kondisi'],
            'biaya_denda'     => $validated['biaya_denda'] ?? 0,
        ]);

        // Update status peminjaman
        $peminjaman->update(['status' => 'returned']);

        // Kembalikan stok barang
        if ($peminjaman->barang) {
            $peminjaman->barang->increment('jumlah_barang', $validated['jumlah_kembali']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Data pengembalian berhasil disimpan.',
            'data'    => $pengembalian
        ], 201);
    }

    // Menampilkan semua data pengembalian
    public function index()
    {
        $pengembalians = Pengembalian::with('peminjaman')->latest()->get();

        return response()->json([
            'success' => true,
            'data'    => $pengembalians
        ]);
    }

    // Menampilkan detail pengembalian berdasarkan ID
    public function show($id)
    {
        $pengembalian = Pengembalian::with('peminjaman')->find($id);

        if (!$pengembalian) {
            return response()->json([
                'success' => false,
                'message' => 'Data pengembalian tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $pengembalian
        ]);
    }

    // Menampilkan peminjaman yang belum dikembalikan
    public function getPeminjamanBelumDikembalikan()
    {
        $peminjaman = Peminjaman::with('barang')
            ->where('status', '!=', 'returned')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $peminjaman
        ]);
    }
}
