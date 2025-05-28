@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-edit me-2 text-primary"></i>
                        <h5 class="mb-0">Form Edit Kategori</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="h3 mb-1 text-dark">
                                <i class="fas fa-tags me-2 text-primary"></i>Edit Kategori
                            </h2>
                            <p class="text-muted mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                Ubah informasi kategori dengan mengisi form di bawah ini
                            </p>
                        </div>
                        <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm border border-danger" role="alert">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <strong>Peringatan!</strong> Ada kesalahan pada input.
                            </div>
                            <ul class="mb-0 ps-4">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('kategori.update', $kategori->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="card border mb-4">
                            <div class="card-body">
                                <div class="mb-4">
                                    <label for="nama_kategori" class="form-label fw-medium">
                                        <i class="fas fa-tag me-2 text-primary"></i>Nama Kategori
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-pencil-alt text-muted"></i>
                                        </span>
                                        <input type="text" 
                                               name="nama_kategori" 
                                               id="nama_kategori" 
                                               class="form-control form-control-lg border-start-0 shadow-none" 
                                               placeholder="Masukkan nama kategori baru"
                                               value="{{ old('nama_kategori', $kategori->nama_kategori) }}" 
                                               required>
                                    </div>
                                    <div class="form-text mt-2">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Masukkan nama kategori yang ingin diubah. Nama kategori harus unik dan mudah diingat.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('kategori.index') }}" class="btn btn-light btn-lg px-4 border">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
