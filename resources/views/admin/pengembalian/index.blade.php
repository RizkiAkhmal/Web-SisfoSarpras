@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card border shadow-sm">
        <div class="card-header bg-white py-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h2 mb-0">Daftar Pengembalian</h2>
                <div class="text-muted">
                    <i class="bi bi-box-arrow-in-left me-1"></i>
                    Total: {{ $pengembalians->count() }} Pengembalian
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0 border-top">
                    <thead class="table-light">
                        <tr>
                            <th class="border-end text-center" style="width: 60px">No</th>
                            <th class="border-end">Nama Pengembali</th>
                            <th class="border-end">Barang</th>
                            <th class="border-end">Tanggal Kembali</th>
                            <th class="border-end text-center" style="width: 80px">Jumlah</th>
                            <th class="border-end">Kondisi</th>
                            <th class="border-end text-end" style="width: 120px">Denda</th>
                            <th class="border-end text-center" style="width: 100px">Status</th>
                            <th class="text-center" style="width: 120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengembalians as $pengembalian)
                        <tr>
                            <td class="border-end text-center">{{ $loop->iteration }}</td>
                            <td class="border-end">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-person-circle me-2 text-muted"></i>
                                    {{ $pengembalian->nama_pengembali }}
                                </div>
                            </td>
                            <td class="border-end">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-box me-2 text-muted"></i>
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
                                @if($pengembalian->status === 'pending')
                                    @if($pengembalian->infoDenda['hari_terlambat'] > 0)
                                        <span class="text-danger">
                                            {{ $pengembalian->infoDenda['hari_terlambat'] }} hari<br>
                                            Rp{{ number_format($pengembalian->infoDenda['denda_keterlambatan'], 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-success">Tepat waktu</span>
                                    @endif
                                @elseif($pengembalian->biaya_denda > 0)
                                    <span class="text-danger">
                                        @if($pengembalian->hari_terlambat > 0)
                                            {{ $pengembalian->hari_terlambat }} hari<br>
                                        @endif
                                        Rp{{ number_format($pengembalian->biaya_denda, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="border-end text-center">
                                @if($pengembalian->status === 'complete')
                                    <span class="badge bg-success">Complete</span>
                                @elseif($pengembalian->status === 'damage')
                                    <span class="badge bg-danger">Damage</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if (!in_array($pengembalian->status, ['complete', 'damage']))
                                    <div class="btn-group">
                                        <form method="POST" 
                                              action="{{ route('pengembalian.approve', $pengembalian->id) }}" 
                                              class="d-inline me-1">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-sm btn-success" 
                                                    data-bs-toggle="tooltip" 
                                                    title="Selesaikan Pengembalian" 
                                                    onclick="return confirm('Selesaikan pengembalian ini?')">
                                                <i class="bi bi-check-lg"></i> Setujui
                                            </button>
                                        </form>

                                        <a href="{{ route('pengembalian.markDamaged', $pengembalian->id) }}" 
                                           class="btn btn-sm btn-danger" 
                                           data-bs-toggle="tooltip" 
                                           title="Tandai Rusak & Input Denda">
                                            <i class="bi bi-exclamation-triangle"></i> Rusak
                                        </a>
                                    </div>
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
