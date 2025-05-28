@extends('layouts.app')

@section('title', 'User Management')

@section('judul_halaman', 'User Management')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h2 class="h3 mb-0 text-dark">Daftar Pengguna</h2>
                <a href="{{ route('user.create') }}" class="btn btn-primary">
                    <i class="fas fa-user-plus me-2"></i>Tambah Pengguna
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Daftar User</h5>
                    <a href="{{ route('user.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle me-1"></i> Tambah User
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 border-top">
                        <thead class="bg-light">
                            <tr>
                                <th class="border-end text-center" style="width: 60px">No</th>
                                <th class="border-end">Nama</th>
                                <th class="border-end">Email</th>
                                <th class="text-center" style="width: 150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $user)
                                <tr>
                                    <td class="border-end text-center">{{ $index + 1 }}</td>
                                    <td class="border-end">{{ $user->name }}</td>
                                    <td class="border-end">{{ $user->email }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('user.edit', $user->id) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit me-1"></i>Edit
                                            </a>
                                            <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                    <i class="fas fa-trash me-1"></i>Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="fas fa-users text-muted mb-3" style="font-size: 2rem;"></i>
                                            <h6 class="fw-bold text-muted">Belum ada data user</h6>
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
@endsection

