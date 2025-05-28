@extends('layouts.app')

@section('title', 'Daftar Peminjaman')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Laporan Peminjaman</h5>
                <div>
                    <a href="{{ route('laporan.peminjaman.export') }}" class="btn btn-success me-2">
                        <i class="fas fa-file-excel me-1"></i> Export Excel
                    </a>
                    <a href="{{ route('laporan.peminjaman.pdf') }}" class="btn btn-danger">
                        <i class="fas fa-file-pdf me-1"></i> Export PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="card-body border-bottom">
            <form action="{{ route('laporan.peminjaman') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0 shadow-none"
                            placeholder="Cari nama peminjam atau barang..." value="{{ request('search') }}"
                            autocomplete="off">
                        @if (request('search'))
                            <a href="{{ route('laporan.peminjaman') }}" class="btn btn-outline-secondary border-start-0">
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
                            <th class="border-end">Nama Akun</th>
                            <th class="border-end">Barang</th>
                            <th class="border-end text-center">Jumlah</th>
                            <th class="border-end">Alasan</th>
                            <th class="border-end">Tanggal Pinjam</th>
                            <th class="border-end">Tanggal Kembali</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjamans as $index => $peminjaman)
                            <tr>
                                <td class="border-end text-center">{{ $index + 1 }}</td>
                                <td class="border-end">{{ $peminjaman->user->name ?? '-' }}</td>
                                <td class="border-end">{{ $peminjaman->barang->nama_barang ?? '-' }}</td>
                                <td class="border-end text-center">{{ $peminjaman->jumlah }}</td>
                                <td class="border-end">{{ $peminjaman->alasan_pinjam }}</td>
                                <td class="border-end">{{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d/m/Y') }}</td>
                                <td class="border-end">{{ \Carbon\Carbon::parse($peminjaman->tgl_kembali)->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    @if($peminjaman->status === 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif($peminjaman->status === 'approved')
                                        <span class="badge bg-success">Approved</span>
                                    @elseif($peminjaman->status === 'rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @elseif($peminjaman->status === 'returned')
                                        <span class="badge bg-primary">Returned</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="fas fa-folder-open text-muted mb-3" style="font-size: 2rem;"></i>
                                        <h6 class="fw-bold text-muted">Belum ada data peminjaman</h6>
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
