@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="h3 mb-1 text-dark">
                            <i class="fas fa-boxes me-2 text-primary"></i>Daftar Barang
                        </h2>

                    </div>
                    <a href="{{ route('barang.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Barang Baru
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm border border-success" role="alert">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-2"></i>
                            <strong>Berhasil!</strong> {{ session('success') }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card border shadow-sm mb-4">
                    <div class="card-body">
                        <form action="{{ route('barang.index') }}" method="GET" class="row g-3 align-items-center">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="fas fa-search text-muted"></i>
                                    </span>
                                    <input type="text" name="search" class="form-control border-start-0 shadow-none"
                                        placeholder="Cari barang atau kategori..." value="{{ request('search') }}"
                                        autocomplete="off">
                                    @if(request('search'))
                                        <a href="{{ route('barang.index') }}" class="btn btn-outline-secondary border-start-0">
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
                </div>

                <div class="card border-0 shadow-sm">
                    
                    <div class="card-body p-0">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle mb-0 border-top">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="border-end text-center" style="width: 60px">
                                            <i class="fas fa-hashtag me-1"></i>No
                                        </th>
                                        <th class="border-end">
                                            <i class="fas fa-image me-1"></i>Foto
                                        </th>
                                        <th class="border-end">
                                            <i class="fas fa-box me-1"></i>Nama Barang
                                        </th>
                                        <th class="border-end text-center">
                                            <i class="fas fa-cubes me-1"></i>Jumlah
                                        </th>
                                        <th class="border-end">
                                            <i class="fas fa-tags me-1"></i>Kategori
                                        </th>
                                        <th class="text-center" style="width: 150px">
                                            <i class="fas fa-cogs me-1"></i>Aksi
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($barangs as $index => $barang)
                                        <tr>
                                            <td class="border-end text-center">{{ $index + 1 }}</td>
                                            <td class="border-end">
                                                <img src="{{ url('storage/' . $barang->foto) }}" 
                                                     alt="{{ $barang->nama_barang }}"
                                                     class="img-thumbnail border"
                                                     style="width: 80px; height: 80px; object-fit: cover;">
                                            </td>
                                            <td class="border-end fw-medium">{{ $barang->nama_barang }}</td>
                                            <td class="border-end text-center">
                                                <span class="badge bg-primary rounded-pill px-3 py-2">
                                                    {{ $barang->jumlah_barang }}
                                                </span>
                                            </td>
                                            <td class="border-end">
                                                <span class="badge bg-light text-dark border fw-semibold">
                                                    {{ $barang->kategoris->nama_kategori ?? '-' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('barang.edit', $barang->id) }}" 
                                                       class="btn btn-warning btn-sm" 
                                                       title="Edit Barang">
                                                        <i class="fas fa-edit me-1"></i>Edit
                                                    </a>
                                                    <form action="{{ route('barang.destroy', $barang->id) }}" 
                                                          method="POST" 
                                                          class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                                                            <i class="fas fa-trash me-1"></i>Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
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
        </div>
    </div>
@endsection
