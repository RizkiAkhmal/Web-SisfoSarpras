@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Admin</title>


    <!-- Main Content -->
    <div class="main">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-4">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-header">Total Kategori</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalKategori }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success mb-3">
                    <div class="card-header">Total Barang</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $totalBarang }}</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-header">Total Orders</div>
                    <div class="card-body">
                        {{-- <h5 class="card-title">{{ $totalOrders }}</h5> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

@endsection
