@extends('layouts.app')

@section('title', 'Edit Barang')
@section('judul_halaman', 'Edit Barang')

@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Oops!</strong> Ada kesalahan input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Tampilkan foto lama --}}
            {{-- @if ($barang->foto)
                <div class="mb-3">
                    <label>Foto Lama:</label><br>
                    <img src="{{ asset('storage/' . $barang->foto) }}" alt="Foto Barang" width="150" class="img-thumbnail">
                </div>
            @endif

            <div class="mb-3">
                <label for="foto" class="form-label">Ganti Foto (Opsional)</label>
                <input type="file" name="foto" class="form-control" accept="image/*">
            </div> --}}

            <div class="mb-3">
                <label for="foto" class="form-label">Foto Barang</label>
                <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
                @if ($barang->foto)
                    <div class="mb-3 text-center">
                        <img src="{{ $barang->foto }}" alt="Foto Barang" style="max-width: 200px;" class="img-thumbnail">
                    </div>
                @endif
            </div>
            
            <div class="mb-3">
                <label for="nama_barang" class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang', $barang->nama_barang) }}" required>
            </div>

            <div class="mb-3">
                <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
                <input type="number" name="jumlah_barang" class="form-control" value="{{ old('jumlah_barang', $barang->jumlah_barang) }}" required>
            </div>

            <div class="mb-3">
                <label for="id_kategori" class="form-label">Kategori</label>
                <select name="id_kategori" class="form-control" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ $kategori->id == $barang->id_kategori ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('barang.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection
