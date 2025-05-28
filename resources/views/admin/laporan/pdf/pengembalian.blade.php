<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pengembalian</title>
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
        <h1>Laporan Pengembalian</h1>
        <p>Tanggal: {{ date('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pengembali</th>
                <th>Barang</th>
                <th>Tanggal Kembali</th>
                <th>Jumlah</th>
                <th>Kondisi</th>
                <th>Denda</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengembalians as $index => $pengembalian)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $pengembalian->nama_pengembali }}</td>
                    <td>{{ $pengembalian->peminjaman->barang->nama_barang ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($pengembalian->tgl_kembali)->format('d/m/Y') }}</td>
                    <td>{{ $pengembalian->jumlah_kembali }}</td>
                    <td>{{ ucfirst($pengembalian->kondisi) }}</td>
                    <td>{{ $pengembalian->biaya_denda > 0 ? 'Rp'.number_format($pengembalian->biaya_denda, 0, ',', '.') : '-' }}</td>
                    <td>{{ ucfirst($pengembalian->status) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak oleh: Admin</p>
    </div>
</body>
</html>