@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="h3 mb-4 text-dark">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </h2>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-3">
            <div class="card h-100 border shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3">
                            <i class="bi bi-box-seam text-primary fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Total Barang</p>
                            <h3 class="h4 mb-0 fw-bold text-dark">{{ $totalBarang }}</h3>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100 border shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3">
                            <i class="bi bi-box-arrow-right text-success fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Barang Dipinjam</p>
                            <h3 class="h4 mb-0 fw-bold text-dark">{{ $totalDipinjam ?? 0 }}</h3>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-success" role="progressbar" 
                             style="width: {{ $persentaseDipinjam }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100 border shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3">
                            <i class="bi bi-people text-info fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Total Peminjam</p>
                            <h3 class="h4 mb-0 fw-bold text-dark">{{ $totalPeminjam ?? 0 }}</h3>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100 border shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                            <i class="bi bi-clock-history text-warning fs-4"></i>
                        </div>
                        <div>
                            <p class="text-muted small mb-1">Pending Approval</p>
                            <h3 class="h4 mb-0 fw-bold text-dark">{{ $totalPending ?? 0 }}</h3>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-warning" role="progressbar" 
                             style="width: {{ $persentasePending }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card border shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-graph-up me-2"></i>Statistik Peminjaman
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <p class="text-muted small mb-1">Barang Tersedia</p>
                                <h4 class="mb-0 fw-bold text-success">{{ number_format($totalBarang - $totalDipinjam) }}</h4>
                                <small class="text-muted">dari total {{ number_format($totalBarang) }} barang</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <p class="text-muted small mb-1">Barang Rusak</p>
                                <h4 class="mb-0 fw-bold text-danger">{{ number_format($totalRusak) }}</h4>
                                <small class="text-muted">{{ number_format(($totalRusak) * 100, 1) }}% dari total barang</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-calendar-check me-2"></i>Status Peminjaman
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <p class="text-muted small mb-1">Sudah Dikembalikan</p>
                                <h4 class="mb-0 fw-bold text-primary">{{ number_format($totalDikembalikan) }}</h4>
                                <small class="text-muted">{{ $totalDipinjam > 0 ? number_format(($totalDikembalikan / ($totalDikembalikan + $totalBelumDikembalikan)) * 100, 1) : 0 }}% dari total peminjaman</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-3">
                                <p class="text-muted small mb-1">Belum Dikembalikan</p>
                                <h4 class="mb-0 fw-bold text-warning">{{ number_format($totalBelumDikembalikan) }}</h4>
                                <small class="text-muted">{{ $totalDipinjam > 0 ? number_format(($totalBelumDikembalikan / ($totalDikembalikan + $totalBelumDikembalikan)) * 100, 1) : 0 }}% dari total peminjaman</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

