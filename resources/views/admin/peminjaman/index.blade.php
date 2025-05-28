@extends('layouts.app')

@section('title', 'Daftar Peminjaman')

@section('content')
    <div class="container py-4">
        <div class="card border shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h2 mb-0">Daftar Peminjaman</h1>
                    <div class="text-muted">
                        <i class="bi bi-calendar-check me-1"></i>
                        Total: {{ $peminjamans->count() }} Peminjaman
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @elseif(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                        <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover table-striped mb-0 border-top">
                        <thead class="table-light">
                            <tr>
                                <th class="border-end text-center" style="width: 60px">ID</th>
                                <th class="border-end">Nama Akun</th>
                                <th class="border-end">Barang</th>
                                <th class="border-end text-center" style="width: 80px">Jumlah</th>
                                <th class="border-end">Alasan</th>
                                <th class="border-end">Tanggal Pinjam</th>
                                <th class="border-end">Tanggal Kembali</th>
                                <th class="border-end text-center" style="width: 100px">Status</th>
                                <th class="text-center" style="width: 150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjamans as $peminjaman)
                                <tr>
                                    <td class="border-end text-center">{{ $peminjaman->id }}</td>
                                    <td class="border-end">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person-circle me-2 text-muted"></i>
                                            {{ $peminjaman->user->name ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="border-end">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-box me-2 text-muted"></i>
                                            {{ $peminjaman->barang->nama_barang ?? '-' }}
                                        </div>
                                    </td>
                                    <td class="border-end text-center">{{ $peminjaman->jumlah }}</td>
                                    <td class="border-end">{{ Str::limit($peminjaman->alasan_pinjam, 30) }}</td>
                                    <td class="border-end">
                                        {{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d/m/Y') }}</td>
                                    <td class="border-end">
                                        {{ \Carbon\Carbon::parse($peminjaman->tgl_kembali)->format('d/m/Y') }}</td>
                                    <td class="border-end text-center">
                                        @if ($peminjaman->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($peminjaman->status === 'approved')
                                            <span class="badge bg-success">Approved</span>
                                        @elseif($peminjaman->status === 'returned')
                                            <span class="badge bg-primary">Returned</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif

                                    </td>
                                    <td class="text-center">
                                        @if ($peminjaman->status === 'pending')
                                            <div class="btn-group">
                                                <form action="{{ route('peminjaman.approve', $peminjaman->id) }}"
                                                    method="POST" class="d-inline me-1">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-success" 
                                                            data-bs-toggle="tooltip" 
                                                            title="Setujui Peminjaman"
                                                            onclick="return confirm('Setujui peminjaman ini?')">
                                                        <i class="bi bi-check-lg"></i> Setujui
                                                    </button>
                                                </form>
                                                <form action="{{ route('peminjaman.reject', $peminjaman->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger" 
                                                            data-bs-toggle="tooltip" 
                                                            title="Tolak Peminjaman"
                                                            onclick="return confirm('Tolak peminjaman ini?')">
                                                        <i class="bi bi-x-lg"></i> Tolak
                                                    </button>
                                                </form>
                                            </div>
                                        @elseif($peminjaman->status === 'approved' && !$peminjaman->pengembalian)
                                            <span class="badge bg-info">Menunggu Pengembalian</span>
                                        @elseif($peminjaman->status === 'returned')
                                            <span class="badge bg-primary">Selesai</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
