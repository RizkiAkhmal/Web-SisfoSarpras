@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Laporan Barang</h5>
                <div>
                    <a href="{{ route('laporan.barang.export') }}" class="btn btn-success me-2">
                        <i class="fas fa-file-excel me-1"></i> Export Excel
                    </a>
                    <a href="{{ route('laporan.barang.pdf') }}" class="btn btn-danger">
                        <i class="fas fa-file-pdf me-1"></i> Export PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="card-body border-bottom">
            <form action="{{ route('laporan.barang') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0 shadow-none"
                            placeholder="Cari barang atau kategori..." value="{{ request('search') }}"
                            autocomplete="off">
                        @if (request('search'))
                            <a href="{{ route('laporan.barang') }}" class="btn btn-outline-secondary border-start-0">
                                <i class="fas fa-times"></i>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-2"></i>Cari
                    </button>
                </div>
            </form>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-end text-center" style="width: 60px">No</th>
                            <th class="border-end">Foto</th>
                            <th class="border-end">Nama Barang</th>
                            <th class="border-end text-center">Jumlah Barang</th>
                            <th>Kategori</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangs as $index => $barang)
                            <tr>
                                <td class="border-end text-center">{{ $index + 1 }}</td>
                                <td class="border-end">
                                    <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}" 
                                         class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                </td>
                                <td class="border-end">{{ $barang->nama_barang }}</td>
                                <td class="border-end text-center">{{ $barang->jumlah_barang }}</td>
                                <td>{{ $barang->kategoris->nama_kategori }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-box-open text-muted mb-3" style="font-size: 2rem;"></i>
                                        <h6 class="fw-bold text-muted">Belum ada data barang</h6>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
