<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index() {
        $barangs = Barang::all();
        return view('admin.barang.index', compact('barangs'));
    }

    public function create() {
        $kategoris = Kategori::all();
        return view('admin.barang.create', compact('kategoris'));
    }

    public function store(Request $request) {
        $this->validate($request, [
            'nama_barang' => 'required',
            'jumlah_barang' => 'required',
            'id_kategori' => 'required|exists:kategoris,id',
            // 'foto' => 'required|image|mimes:jpeg,png,jpg',
            'foto' => 'nullable|url'
        ]);

        // $foto = $request->file('foto');
        // $foto->storeAs('public', $foto->hashName());

        $data = $request->all();
        $data['foto'] = $request->input('foto');

        Barang::create([
            'nama_barang' => $request->nama_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'id_kategori' => $request->id_kategori,
            'foto' => $request->foto, 
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit($id) {
        $barang = Barang::findOrFail($id);
        $kategoris = Kategori::all();

        return view('admin.barang.edit', compact('barang', 'kategoris'));
    }

    public function update($id, Request $request) {
        $this->validate($request, [
            'nama_barang' => 'required',
            'jumlah_barang' => 'required',
            'id_kategori' => 'required|exists:kategoris,id',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg',
            'foto' => 'nullable|url',
        ]);

        $barang = Barang::findOrFail($id);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika bukan default
            if ($barang->foto && $barang->foto != 'noimage.png') {
                Storage::delete('public/' . $barang->foto);
            }

            $foto = $request->file('foto');
            $foto->storeAs('public', $foto->hashName());
            $barang->foto = $foto->hashName();
        }

        $barang->update([
            'nama_barang' => $request->nama_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'id_kategori' => $request->id_kategori,
            'foto' => $barang->foto, // tetap simpan foto terbaru atau lama
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function delete($id) {
        $barang = Barang::findOrFail($id);

        // Hapus foto dari storage jika bukan default
        if ($barang->foto && $barang->foto != 'noimage.png') {
            Storage::delete('public/' . $barang->foto);
        }

        $barang->delete();
        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
