@extends('layouts.app')

@section('title', 'Edit Pengguna')

@section('judul_halaman', 'Edit Pengguna')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-edit me-2 text-primary"></i>
                        <h5 class="mb-0">Form Edit Pengguna</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h2 class="h3 mb-1 text-dark">
                                <i class="fas fa-user me-2 text-primary"></i>Edit Pengguna
                            </h2>
                            <p class="text-muted mb-0">
                                <i class="fas fa-info-circle me-1"></i>
                                Ubah informasi pengguna dengan mengisi form di bawah ini
                            </p>
                        </div>
                        <a href="{{ route('user.index') }}" class="btn btn-outline-secondary">
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

                    <form action="{{ route('user.update', $user->id) }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="card border mb-4">
                            <div class="card-body">
                                <div class="mb-4">
                                    <label for="name" class="form-label fw-medium">
                                        <i class="fas fa-user me-2 text-primary"></i>Nama
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-user text-muted"></i>
                                        </span>
                                        <input type="text"
                                               name="name"
                                               id="name"
                                               class="form-control form-control-lg border-start-0 shadow-none"
                                               placeholder="Masukkan nama pengguna"
                                               value="{{ old('name', $user->name) }}"
                                               required>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="email" class="form-label fw-medium">
                                        <i class="fas fa-envelope me-2 text-primary"></i>Email
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-envelope text-muted"></i>
                                        </span>
                                        <input type="email"
                                               name="email"
                                               id="email"
                                               class="form-control form-control-lg border-start-0 shadow-none"
                                               placeholder="Masukkan email pengguna"
                                               value="{{ old('email', $user->email) }}"
                                               required>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="password" class="form-label fw-medium">
                                        <i class="fas fa-lock me-2 text-primary"></i>Password
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-lock text-muted"></i>
                                        </span>
                                        <input type="password"
                                               name="password"
                                               id="password"
                                               class="form-control form-control-lg border-start-0 shadow-none"
                                               placeholder="Masukkan password baru (kosongkan jika tidak ingin mengubah)">
                                    </div>
                                    <div class="form-text mt-2">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Biarkan kosong jika tidak ingin mengubah password
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label fw-medium">
                                        <i class="fas fa-lock me-2 text-primary"></i>Konfirmasi Password
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0">
                                            <i class="fas fa-lock text-muted"></i>
                                        </span>
                                        <input type="password"
                                               name="password_confirmation"
                                               id="password_confirmation"
                                               class="form-control form-control-lg border-start-0 shadow-none"
                                               placeholder="Konfirmasi password baru">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('user.index') }}" class="btn btn-light btn-lg px-4 border">
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