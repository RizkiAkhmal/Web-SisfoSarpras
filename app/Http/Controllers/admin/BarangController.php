<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::all();
        return view('admin.barang.index', compact('barangs'));
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
            'foto'          => 'nullable|url'
        ]);

        Barang::create([
            'nama_barang'   => $request->nama_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'id_kategori'   => $request->id_kategori,
            'foto'          => $request->foto, // simpan URL foto
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategoris = Kategori::all();

        return view('admin.barang.edit', compact('barang', 'kategoris'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang'   => 'required|string|max:255',
            'jumlah_barang' => 'required|integer',
            'id_kategori'   => 'required|exists:kategoris,id',
            'foto'          => 'nullable|url'
        ]);

        $barang = Barang::findOrFail($id);

        $barang->update([
            'nama_barang'   => $request->nama_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'id_kategori'   => $request->id_kategori,
            'foto'          => $request->foto, // ganti URL foto lama
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function delete($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
