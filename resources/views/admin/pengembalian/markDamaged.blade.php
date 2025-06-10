@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>
                        <h5 class="card-title mb-0">Input Denda Pengembalian Rusak</h5>
                    </div>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="d-flex">
                                <i class="bi bi-exclamation-circle-fill me-2"></i>
                                <div>
                                    <strong>Terjadi kesalahan!</strong>
                                    <ul class="mb-0 mt-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('pengembalian.updateDamaged', $pengembalian->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating border rounded">
                                    <input type="text" class="form-control bg-light" id="nama_pengembali" 
                                           value="{{ $pengembalian->nama_pengembali }}" disabled>
                                    <label for="nama_pengembali" class="ps-3">Nama Pengembali</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating border rounded">
                                    <input type="text" class="form-control bg-light" id="barang" 
                                           value="{{ $pengembalian->peminjaman->barang->nama_barang ?? '-' }}" disabled>
                                    <label for="barang" class="ps-3">Nama Barang</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating border rounded">
                                    <input type="number" class="form-control bg-light" id="jumlah_kembali" 
                                           value="{{ $pengembalian->jumlah_kembali }}" disabled>
                                    <label for="jumlah_kembali" class="ps-3">Jumlah Dikembalikan</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating border rounded">
                                    <input type="text" class="form-control bg-light" id="keterlambatan" 
                                           value="{{ isset($pengembalian->infoDenda) ? $pengembalian->infoDenda['hari_terlambat'].' hari (Rp'.number_format($pengembalian->infoDenda['denda_keterlambatan'], 0, ',', '.').')' : '0 hari (Rp0)' }}" disabled>
                                    <label for="keterlambatan" class="ps-3">Keterlambatan & Denda</label>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-floating border rounded">
                                    <input type="number" class="form-control" name="denda" id="denda" 
                                           placeholder="Masukkan jumlah denda kerusakan" required min="0">
                                    <label for="denda" class="ps-3">Denda Kerusakan (Rp)</label>
                                    <small class="text-muted ps-3">Denda ini akan ditambahkan dengan denda keterlambatan (jika ada)</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4 border-top pt-3">
                            <button type="submit" class="btn btn-danger">
                                <i class="bi bi-exclamation-triangle me-1"></i> Simpan Denda & Tandai Rusak
                            </button>

                            <a href="{{ route('pengembalian.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
