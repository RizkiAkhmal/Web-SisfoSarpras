@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Laporan Pengembalian</h5>
                <div>
                    <a href="{{ route('laporan.pengembalian.export') }}" class="btn btn-success me-2">
                        <i class="fas fa-file-excel me-1"></i> Export Excel
                    </a>
                    <a href="{{ route('laporan.pengembalian.pdf') }}" class="btn btn-danger">
                        <i class="fas fa-file-pdf me-1"></i> Export PDF
                    </a>
                </div>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="card-body border-bottom">
            <form action="{{ route('laporan.pengembalian') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0 shadow-none"
                            placeholder="Cari nama pengembali atau barang..." value="{{ request('search') }}"
                            autocomplete="off">
                        @if (request('search'))
                            <a href="{{ route('laporan.pengembalian') }}" class="btn btn-outline-secondary border-start-0">
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
                            <th class="border-end">Nama Pengembali</th>
                            <th class="border-end">Barang</th>
                            <th class="border-end">Tanggal Kembali</th>
                            <th class="border-end text-center" style="width: 80px">Jumlah</th>
                            <th class="border-end">Kondisi</th>
                            <th class="border-end text-end" style="width: 120px">Denda</th>
                            <th class="text-center" style="width: 100px">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengembalians as $index => $pengembalian)
                        <tr>
                            <td class="border-end text-center">{{ $index + 1 }}</td>
                            <td class="border-end">
                                <div class="d-flex align-items-center">
                                    {{ $pengembalian->nama_pengembali }}
                                </div>
                            </td>
                            <td class="border-end">
                                <div class="d-flex align-items-center">
                                    {{ $pengembalian->peminjaman->barang->nama_barang ?? '-' }}
                                </div>
                            </td>
                            <td class="border-end">
                                {{ \Carbon\Carbon::parse($pengembalian->tgl_kembali)->format('d/m/Y') }}
                            </td>
                            <td class="border-end text-center">
                                {{ $pengembalian->jumlah_kembali }}
                            </td>
                            <td class="border-end">
                                @if($pengembalian->kondisi === 'baik')
                                    <span class="badge bg-success">Baik</span>
                                @elseif($pengembalian->kondisi === 'rusak')
                                    <span class="badge bg-danger">Rusak</span>
                                @else
                                    <span class="badge bg-dark">Hilang</span>
                                @endif
                            </td>
                            <td class="border-end text-end">
                                @if($pengembalian->biaya_denda > 0)
                                    <span class="text-danger">
                                        Rp{{ number_format($pengembalian->biaya_denda, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($pengembalian->status === 'complete')
                                    <span class="badge bg-success">Complete</span>
                                @elseif($pengembalian->status === 'damage')
                                    <span class="badge bg-danger">Damage</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="fas fa-undo text-muted mb-3" style="font-size: 2rem;"></i>
                                    <h6 class="fw-bold text-muted">Belum ada data pengembalian</h6>
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
