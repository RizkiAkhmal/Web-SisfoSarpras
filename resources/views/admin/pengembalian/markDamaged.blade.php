@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Input Denda Pengembalian Rusak</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pengembalian.updateDamaged', $pengembalian->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_pengembali" class="form-label">Nama Pengembali</label>
            <input type="text" class="form-control" id="nama_pengembali" 
                   value="{{ $pengembalian->nama_pengembali }}" disabled>
        </div>

        <div class="mb-3">
            <label for="barang" class="form-label">Nama Barang</label>
            <input type="text" class="form-control" id="barang" 
                   value="{{ $pengembalian->peminjaman->barang->nama_barang ?? '-' }}" disabled>
        </div>

        <div class="mb-3">
            <label for="jumlah_kembali" class="form-label">Jumlah Dikembalikan</label>
            <input type="number" class="form-control" id="jumlah_kembali" 
                   value="{{ $pengembalian->jumlah_kembali }}" disabled>
        </div>

        <div class="mb-3">
            <label for="denda" class="form-label">Denda (Rp)</label>
            <input type="number" class="form-control" name="denda" id="denda" 
                   placeholder="Masukkan jumlah denda" required min="0">
        </div>

        <button type="submit" class="btn btn-danger">
            <i class="bi bi-exclamation-triangle me-1"></i> Simpan Denda & Tandai Rusak
        </button>

        <a href="{{ route('pengembalian.index') }}" class="btn btn-secondary ms-2">
            Kembali
        </a>
    </form>
</div>
@endsection
