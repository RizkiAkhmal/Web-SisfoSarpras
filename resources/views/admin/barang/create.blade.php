@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 pb-0">
                    <h3 class="mb-0">Tambah Barang</h3>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <strong>Oops!</strong> Ada kesalahan input.<br><br>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto Barang</label>
                            <input type="file" class="form-control" name="foto" accept="image/jpeg,image/png,image/jpg" required>
                        </div>
                        {{-- <div class="mb-3">
                            <label for="foto" class="form-label">Link Foto Barang</label>
                            <input type="text" name="foto" id="foto" class="form-control" placeholder="https://..." value="{{ old('foto') }}">
                        </div> --}}

                        <div class="mb-3">
                            <label for="nama_barang" class="form-label">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" value="{{ old('nama_barang') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
                            <input type="number" name="jumlah_barang" class="form-control" value="{{ old('jumlah_barang') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_kategori" class="form-label">Kategori</label>
                            <select name="id_kategori" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategoris as $kategori)
                                    <option value="{{ $kategori->id }}" {{ old('id_kategori') == $kategori->id ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('barang.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection