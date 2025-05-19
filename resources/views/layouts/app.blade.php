<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Halaman')</title>

    <!-- Bootstrap & Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: #f1f1f1;
        }

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #163172;
            color: white;
            padding: 20px 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar .user-info {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar .user-info img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: #000;
        }

        .sidebar .user-info h5,
        .sidebar .user-info p {
            margin: 10px 0 0;
        }

        .sidebar .nav-link {
            background-color: #1f4e8c;
            color: white;
            margin: 6px 0;
            border-radius: 5px;
            padding: 10px 15px;
            transition: 0.3s;
            display: block;
        }

        .sidebar .nav-link:hover {
            background-color: #2563eb;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        .logout-button {
            margin-top: auto;
        }

        .main {
            flex-grow: 1;
            padding: 30px;
        }

        .submenu-icon {
            float: right;
        }
    </style>
</head>
<body>

    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <div>
                <div class="user-info">
                    {{-- <img src="https://via.placeholder.com/80" alt="User Avatar"> --}}
                    <h5>{{ Auth::user()->name }}</h5>
                    <p>{{ Auth::user()->email }}</p>
                </div>

                <a href="/admin/dashboard" class="nav-link"><i class="fas fa-home"></i>DASHBOARD</a>
                <a href="{{ route('barang.index') }}" class="nav-link"><i class="fas fa-box"></i>DATA BARANG</a>
                <a href="{{ route('kategori.index') }}" class="nav-link"><i class="fas fa-folder"></i>DATA KATEGORI</a>
                <a href="{{route('peminjaman.index')}}" class="nav-link"><i class="fas fa-folder-open"></i>DATA PEMINJAMAN</a>
                <a href="{{route('pengembalian.index')}}" class="nav-link"><i class="fas fa-undo"></i>DATA PENGEMBALIAN</a>
                {{-- <a href="/history/peminjaman" class="nav-link"><i class="fas fa-file-alt"></i>HISTORY PEMINJAMAN</a>
                <a href="/history/pengembalian" class="nav-link"><i class="fas fa-file-alt"></i>HISTORY PENGEMBALIAN</a> --}}

                                <!-- Laporan Menu with Submenu -->
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#laporanSubmenu" role="button" aria-expanded="false" aria-controls="laporanSubmenu">
                    <span><i class="fas fa-chart-line"></i> LAPORAN</span>
                    <i class="fas fa-chevron-down submenu-icon" id="laporanIcon"></i>
                </a>
                <div class="collapse" id="laporanSubmenu">
                    <a href="{{route('laporan.barang')}}" class="nav-link ms-3"><i class="fas fa-angle-right"></i> Laporan Barang</a>
                    <a href="{{route('laporan.peminjaman')}}" class="nav-link ms-3"><i class="fas fa-angle-right"></i> Laporan Peminjamann</a>
                </div>

                <!-- Laporan Menu with Submenu -->
                <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#historySubmenu" role="button" aria-expanded="false" aria-controls="laporanSubmenu">
                    <span><i class="fas fa-chart-line"></i> HISTORY </span>
                    <i class="fas fa-chevron-down submenu-icon" id="laporanIcon"></i>
                </a>
                <div class="collapse" id="historySubmenu">
                    <a href="/laporan/peminjaman" class="nav-link ms-3"><i class="fas fa-angle-right"></i> History Peminjaman</a>
                    <a href="/laporan/pengembalian" class="nav-link ms-3"><i class="fas fa-angle-right"></i> History Pengembalian</a>
                </div>


            </div>

            <div class="logout-button">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light w-100">
                        <i class="fas fa-sign-out-alt"></i> LOG OUT
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main">
            <div class="container">
                <h2>@yield('judul_halaman')</h2>
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with JS for Collapse -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

   </body>
</html>
