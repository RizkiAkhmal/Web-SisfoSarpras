@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Pengembalian</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pengembali</th>
                    <th>Barang</th>
                    <th>Tanggal Kembali</th>
                    <th>Jumlah</th>
                    <th>Kondisi</th>
                    <th>Denda</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengembalians as $pengembalian)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pengembalian->nama_pengembali }}</td>
                        <td>{{ $pengembalian->peminjaman->barang->nama_barang ?? '-' }}</td>
                        <td>{{ $pengembalian->tgl_kembali }}</td>
                        <td>{{ $pengembalian->jumlah_kembali }}</td>
                        <td>{{ $pengembalian->kondisi }}</td>
                        <td>Rp{{ number_format($pengembalian->biaya_denda, 0, ',', '.') }}</td>
                        <td>{{ ucfirst($pengembalian->status) }}</td>
                        <td class="px-4 text-center">
                            @if ($pengembalian->status !== 'complete' && $pengembalian->status !== 'damage')
                                <div class="btn-group">
                                    <form method="POST" action="{{ route('pengembalian.approve', $pengembalian->id) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-sm btn-success d-flex align-items-center me-1" 
                                                data-bs-toggle="tooltip" 
                                                title="Selesaikan" 
                                                onclick="return confirm('Selesaikan pengembalian ini?')">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </form>

                                    <a href="{{ route('pengembalian.markDamaged', $pengembalian->id) }}" 
                                       class="btn btn-sm btn-outline-danger d-flex align-items-center" 
                                       data-bs-toggle="tooltip" 
                                       title="Tandai Rusak">
                                        <i class="bi bi-exclamation-triangle"></i>
                                    </a>
                                </div>
                            @else
                                <span class="badge bg-light text-secondary">Tidak ada aksi</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
