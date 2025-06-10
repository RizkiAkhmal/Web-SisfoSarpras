<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title', 'Halaman')</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

  <style>
    /* Base & Typography */
    * {
      box-sizing: border-box;
      font-family: 'Poppins', sans-serif;
    }

    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      background-color: #f8f9fa;
    }

    /* Layout */
    .wrapper {
      display: flex;
      min-height: 100vh;
    }

    .main {
      flex-grow: 1;
      padding: 30px;
      margin-left: 280px;
      width: calc(100% - 280px);
      background-color: #f8f9fa;
    }

    /* Sidebar */
    .sidebar {
      position: fixed;
      width: 280px;
      background: linear-gradient(135deg, #1a237e 0%, #283593 100%);
      color: white;
      padding: 15px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      height: 100vh;
      z-index: 1000;
      box-shadow: 0 0 20px rgba(0,0,0,0.1);
    }

    .sidebar .user-info {
      text-align: center;
      margin-bottom: 15px;
      background: rgba(255,255,255,0.1);
      border-radius: 10px;
      padding: 12px 10px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .sidebar .user-info h5 {
      margin: 3px 0 5px;
      font-size: 1.1rem;
      font-weight: 600;
      color: #fff;
      text-shadow: 0 1px 2px rgba(0,0,0,0.2);
    }
    
    .sidebar .user-info p {
      margin: 0;
      font-size: 0.85rem;
      opacity: 0.9;
      color: #e0e0e0;
    }

    .sidebar .nav-link {
      background-color: rgba(255,255,255,0.1);
      color: white;
      margin: 6px 0;
      border-radius: 8px;
      padding: 10px 15px;
      transition: all 0.3s ease;
      font-size: 0.9rem;
      font-weight: 500;
      letter-spacing: 0.3px;
      border-left: 3px solid transparent;
      display: flex;
      align-items: center;
    }

    .sidebar .nav-link:hover, .sidebar .nav-link.active {
      background-color: rgba(255,255,255,0.2);
      border-left: 3px solid #64b5f6;
      transform: translateX(3px);
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .sidebar .nav-link i {
      margin-right: 10px;
      font-size: 1rem;
      width: 24px;
      height: 24px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(255,255,255,0.2);
      border-radius: 6px;
      padding: 5px;
    }

    /* Menu divider */
    .menu-divider {
      height: 1px;
      background: rgba(255,255,255,0.2);
      margin: 12px 0;
      position: relative;
    }
    
    .menu-divider span {
      position: absolute;
      top: -8px;
      left: 10px;
      background: rgba(0,0,0,0.3);
      padding: 2px 8px;
      border-radius: 4px;
      font-size: 0.75rem;
      color: rgba(255,255,255,0.8);
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    /* Report link styling */
    .sidebar .nav-link.report-link {
      background-color: rgba(255,193,7,0.15);
    }
    
    .sidebar .nav-link.report-link:hover, .sidebar .nav-link.report-link.active {
      background-color: rgba(255,193,7,0.25);
      border-left: 3px solid #ffc107;
    }
    
    .sidebar .nav-link.report-link i {
      background: rgba(255,193,7,0.3);
    }

    /* Logout button */
    .logout-button {
      margin-top: 15px;
    }
    
    .logout-button .btn {
      padding: 10px;
      font-size: 0.9rem;
      font-weight: 500;
      border-radius: 8px;
      transition: all 0.3s;
      background: rgba(255,255,255,0.1);
      border: 1px solid rgba(255,255,255,0.2);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    
    .logout-button .btn:hover {
      background-color: rgba(255,0,0,0.2);
      border-color: rgba(255,0,0,0.3);
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    
    .logout-button .btn i {
      font-size: 1rem;
    }

    /* Content container */
    .container {
      background-color: white;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 0 15px rgba(0,0,0,0.05);
    }
    
    h2 {
      color: #333;
      font-weight: 600;
      margin-bottom: 25px;
      padding-bottom: 15px;
      border-bottom: 1px solid #eee;
    }

    /* Table styling */
    .table {
      border-color: #e0e0e0;
    }
    
    .table thead {
      background-color: #f8f9fa;
    }
    
    .table thead th {
      font-weight: 600;
      color: #495057;
      border-bottom-width: 1px;
      vertical-align: middle;
      padding: 12px 15px;
      font-size: 0.9rem;
    }
    
    .table tbody td {
      padding: 12px 15px;
      vertical-align: middle;
      border-color: #e0e0e0;
      color: #333;
    }
    
    /* Table variations */
    .table-striped tbody tr:nth-of-type(odd) { background-color: rgba(0, 0, 0, 0.02); }
    .table-striped tbody tr:nth-of-type(even) { background-color: #ffffff; }
    .table-hover tbody tr:hover { background-color: rgba(0, 123, 255, 0.03); }
    .table-striped.table-hover tbody tr:hover { background-color: rgba(0, 123, 255, 0.05); }
    
    /* Table borders */
    .table-bordered { border: 1px solid #e0e0e0; }
    .table-bordered th, .table-bordered td { border: 1px solid #e0e0e0; }

    /* Badges */
    .badge {
      padding: 0.4em 0.65em;
      font-weight: 500;
      font-size: 0.75rem;
      border-radius: 4px;
    }
    
    /* Badge colors */
    .badge.bg-success { background-color: #28a745 !important; }
    .badge.bg-danger { background-color: #dc3545 !important; }
    .badge.bg-warning { background-color: #ffc107 !important; color: #212529; }
    .badge.bg-info { background-color: #17a2b8 !important; }
    .badge.bg-primary { background-color: #007bff !important; }
    .badge.bg-secondary { background-color: #6c757d !important; }
    .badge.bg-dark { background-color: #343a40 !important; }

    /* Buttons */
    .btn {
      font-weight: 500;
      transition: all 0.2s ease;
    }
    
    /* Table buttons */
    .table .btn {
      padding: 0.375rem 0.75rem;
      font-size: 0.875rem;
      border-radius: 4px;
    }
    
    .table .btn-sm {
      padding: 0.25rem 0.5rem;
      font-size: 0.75rem;
      display: flex;
      align-items: center;
      justify-content: center;
      min-width: 70px;
    }
    
    /* Button colors */
    .btn-warning { background-color: #ffc107; border-color: #ffc107; color: #212529; }
    .btn-warning:hover { background-color: #e0a800; border-color: #d39e00; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    
    .btn-danger { background-color: #dc3545; border-color: #dc3545; color: #fff; }
    .btn-danger:hover { background-color: #c82333; border-color: #bd2130; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    
    .btn-success { background-color: #28a745; border-color: #28a745; color: #fff; }
    .btn-success:hover { background-color: #218838; border-color: #1e7e34; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
    
    .btn-primary { background-color: #007bff; border-color: #007bff; color: #fff; }
    .btn-primary:hover { background-color: #0069d9; border-color: #0062cc; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }

    /* Cards */
    .card {
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
      border: 1px solid #e0e0e0;
      overflow: hidden;
    }
    
    .card-header {
      background-color: #fff;
      border-bottom: 1px solid #e0e0e0;
      padding: 15px 20px;
    }
    
    .card-body {
      padding: 20px;
    }
    
    /* Utilities */
    .gap-2 {
      gap: 0.5rem !important;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar">
      <div>
        <!-- User Info -->
        <div class="user-info">
          <h5>{{ Auth::user()->name }}</h5>
          <p>{{ Auth::user()->email }}</p>
        </div>

        <!-- Menu Dashboard -->
        <div class="menu-group">
          <a href="/admin/dashboard" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i> DASHBOARD
          </a>
        </div>
        
        <!-- Menu Data -->
        <div class="menu-divider">
          <span>Data Master</span>
        </div>
        
        <div class="menu-group">
          <a href="{{ route('user.index') }}" class="nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}">
            <i class="fas fa-users"></i> USER MANAGEMENT
          </a>
          <a href="{{ route('kategori.index') }}" class="nav-link {{ request()->routeIs('kategori.index') ? 'active' : '' }}">
            <i class="fas fa-folder"></i> DATA KATEGORI
          </a>
          <a href="{{ route('barang.index') }}" class="nav-link {{ request()->routeIs('barang.index') ? 'active' : '' }}">
            <i class="fas fa-box"></i> DATA BARANG
          </a>
          <a href="{{ route('peminjaman.index') }}" class="nav-link {{ request()->routeIs('peminjaman.index') ? 'active' : '' }}">
            <i class="fas fa-folder-open"></i> DATA PEMINJAMAN
          </a>
          <a href="{{ route('pengembalian.index') }}" class="nav-link {{ request()->routeIs('pengembalian.index') ? 'active' : '' }}">
            <i class="fas fa-undo"></i> DATA PENGEMBALIAN
          </a>
        </div>
        
        <!-- Menu Laporan -->
        <div class="menu-divider">
          <span>Laporan</span>
        </div>
        
        <div class="menu-group">
          <a href="{{ route('laporan.barang') }}" class="nav-link report-link {{ request()->routeIs('laporan.barang') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i> LAPORAN BARANG
          </a>
          <a href="{{ route('laporan.peminjaman') }}" class="nav-link report-link {{ request()->routeIs('laporan.peminjaman') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i> LAPORAN PEMINJAMAN
          </a>
          <a href="{{ route('laporan.pengembalian') }}" class="nav-link report-link {{ request()->routeIs('laporan.pengembalian') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i> LAPORAN PENGEMBALIAN
          </a>
        </div>
      </div>

      <!-- Logout -->
      <div class="logout-button">
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn w-100">
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

  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
