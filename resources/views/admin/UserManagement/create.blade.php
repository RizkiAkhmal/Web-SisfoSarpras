@extends('layouts.app')

@section('title', 'Tambah Pengguna')

@section('judul_halaman', 'Tambah Pengguna')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h3 mb-0 text-dark">Tambah Pengguna Baru</h2>
                        <a href="{{ route('user.index') }}" class="btn btn-outline-secondary">
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

                    <form action="{{ route('user.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-4">
                            <label for="name" class="form-label fw-medium">Nama</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input type="text"
                                       name="name"
                                       id="name"
                                       class="form-control form-control-lg"
                                       placeholder="Masukkan nama pengguna"
                                       value="{{ old('name') }}"
                                       required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label fw-medium">Email</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <input type="email"
                                       name="email"
                                       id="email"
                                       class="form-control form-control-lg"
                                       placeholder="Masukkan email pengguna"
                                       value="{{ old('email') }}"
                                       required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-medium">Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password"
                                       name="password"
                                       id="password"
                                       class="form-control form-control-lg"
                                       placeholder="Masukkan password"
                                       required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label fw-medium">Konfirmasi Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input type="password"
                                       name="password_confirmation"
                                       id="password_confirmation"
                                       class="form-control form-control-lg"
                                       placeholder="Konfirmasi password"
                                       required>
                            </div>
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