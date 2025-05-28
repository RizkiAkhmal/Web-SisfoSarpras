@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h3 mb-0 text-dark">Tambah Kategori</h2>
                        <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <strong>Oops!</strong> Ada kesalahan pada input.
                            </div>
                            <ul class="mb-0 ps-4">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('kategori.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-4">
                            <label for="nama_kategori" class="form-label fw-medium">Nama Kategori</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-tag"></i>
                                </span>
                                <input type="text" 
                                       name="nama_kategori" 
                                       id="nama_kategori" 
                                       class="form-control form-control-lg" 
                                       placeholder="Masukkan nama kategori"
                                       value="{{ old('nama_kategori') }}" 
                                       required>
                            </div>
                            <div class="form-text">Masukkan nama kategori yang ingin ditambahkan</div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-save me-2"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection