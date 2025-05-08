@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>


    <!-- Main Content -->
    <div class="main">
        <div class="container py-4">
            <h2 class="mb-4">Daftar Barang</h2>

            {{-- Flash message --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- Tombol Tambah --}}
            <a href="{{ route('barang.create') }}" class="btn btn-primary mb-3">+ Tambah Barang</a>

            {{-- Tabel Barang --}}
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Foto Barang</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangs as $index => $barang)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                {{-- <td><img src="{{ asset('storage/' . $barang->foto) }}" width="80"></td> --}}
                                <td>
                                    @if($barang->foto)
                                            <img src="{{ $barang->foto }}" alt="Foto {{ $barang->nama }}" width="60">
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </td>
                                <td>{{ $barang->nama_barang }}</td>
                                <td>{{ $barang->jumlah_barang }}</td>
                                <td>{{ $barang->kategoris->nama_kategori ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('barang.edit', $barang->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data barang</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>

@endsection
