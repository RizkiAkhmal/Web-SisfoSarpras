<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(Request $request) {
        $search = $request->search;
        
        $kategoris = Kategori::when($search, function($query) use ($search) {
            return $query->where('nama_kategori', 'like', "%{$search}%");
        })->get();

        return view('admin.kategori.index', compact('kategoris', 'search'));
    }

    public function create() {
        return view('admin.kategori.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'nama_kategori' => 'required|string|max:255'
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id) {
        $kategori = Kategori::findOrFail($id);
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, $id) {
        $this->validate($request, [
            'nama_kategori' => 'required|string|max:255'
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy($id) {
        Kategori::findOrFail($id)->delete();
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
