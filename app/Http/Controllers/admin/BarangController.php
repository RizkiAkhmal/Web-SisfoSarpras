<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query();

        // Handle searchbar
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhereHas('kategoris', function($q) use ($search) {
                      $q->where('nama_kategori', 'like', "%{$search}%");
                  });
            });
        }

        $barangs = $query->get();
        $kategoris = Kategori::all(); // For dropdown filter if needed later

        return view('admin.barang.index', compact('barangs', 'kategoris'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.barang.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang'   => 'required|string|max:255',
            'jumlah_barang' => 'required|integer',
            'id_kategori'   => 'required|exists:kategoris,id',
            'foto' => 'required|image|mimes:jpeg,png,jpg',
            // 'foto'          => 'nullable|url'
        ]);

        $foto = $request->file('foto');
        $foto->storeAs('public', $foto->hashName()); // Store foto in public storage

        Barang::create([
            'nama_barang'   => $request->nama_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'id_kategori'   => $request->id_kategori,
            // 'foto'          => $request->foto, // simpan URL foto
            'foto' => $foto->hashName(), // Store the hashed filename
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit($id){
        $barang = Barang::findOrFail($id);
        $kategoris = Kategori::all();

        return view('admin.barang.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, $id){
    // Validasi input
    $request->validate([
        'nama_barang'   => 'required|string|max:255',
        'jumlah_barang' => 'required|integer',
        'id_kategori'   => 'required|exists:kategoris,id',
        'foto'          => 'nullable|image|mimes:jpeg,png,jpg',
    ]);

    // Ambil data barang berdasarkan ID
    $barang = Barang::findOrFail($id);

    // Cek jika ada file foto baru
    if ($request->hasFile('foto')) {
        $foto = $request->file('foto');
        $foto->storeAs('public', $foto->hashName());

        // Update semua data termasuk foto
        $barang->update([
            'nama_barang'   => $request->nama_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'id_kategori'   => $request->id_kategori,
            'foto'          => $foto->hashName(),
        ]);
    } else {
        // Update data tanpa mengganti foto
        $barang->update([
            'nama_barang'   => $request->nama_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'id_kategori'   => $request->id_kategori,
        ]);
    }

    return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
}


    public function delete($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
