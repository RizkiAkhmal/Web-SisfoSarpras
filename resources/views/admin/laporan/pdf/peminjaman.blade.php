<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Peminjaman</h1>
        <p>Tanggal: {{ date('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Akun</th>
                <th>Barang</th>
                <th>Jumlah</th>
                <th>Alasan</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjamans as $index => $peminjaman)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $peminjaman->user->name ?? '-' }}</td>
                    <td>{{ $peminjaman->barang->nama_barang ?? '-' }}</td>
                    <td>{{ $peminjaman->jumlah }}</td>
                    <td>{{ $peminjaman->alasan_pinjam }}</td>
                    <td>{{ $peminjaman->tgl_pinjam }}</td>
                    <td>{{ $peminjaman->tgl_kembali }}</td>
                    <td>{{ ucfirst($peminjaman->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: Admin</p>
    </div>
</body>
</html>