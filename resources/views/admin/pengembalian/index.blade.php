@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Daftar Pengembalian</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
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
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
