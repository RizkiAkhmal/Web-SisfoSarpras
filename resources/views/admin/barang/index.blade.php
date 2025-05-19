@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4">📦 Daftar Barang</h2>
        <hr class="border border-primary border-2 opacity-100 w-25 mb-4">

        {{-- Flash message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Tombol Tambah --}}
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('barang.create') }}" class="btn btn-primary shadow-sm">
                + Tambah Barang
            </a>
        </div>

        {{-- Tabel Barang --}}
        <div class="card shadow-sm rounded">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Foto</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barangs as $index => $barang)
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>
                                {{-- <td>
                                @if ($barang->foto)
                                    <img src="{{ $barang->foto }}" alt="Foto {{ $barang->nama_barang }}" width="60" class="rounded shadow-sm">
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td> --}}
                                <td>
                                    <img src="{{ url('storage/' . $barang->foto) }}" alt="{{ $barang->name }}"
                                        style="width: 100px; height: auto;" class="img-fluid rounded shadow-sm">
                                </td>

                                <td>{{ $barang->nama_barang }}</td>
                                <td>{{ $barang->jumlah_barang }}</td>
                                <td>{{ $barang->kategoris->nama_kategori ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('barang.edit', $barang->id) }}"
                                        class="btn btn-warning btn-sm me-1">Edit</a>
                                    <form action="{{ route('barang.destroy', $barang->id) }}" method="POST"
                                        style="display:inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin hapus?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    Belum ada data barang 📭
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
