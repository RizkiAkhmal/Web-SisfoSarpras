<?php

namespace App\Exports;

use App\Models\Pengembalian;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PengembalianExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Pengembalian::with(['peminjaman', 'peminjaman.barang'])
            ->get()
            ->map(function ($item) {
                return [
                    'nama_pengembali' => $item->nama_pengembali,
                    'barang' => $item->peminjaman->barang->nama_barang ?? '-',
                    'tgl_kembali' => Carbon::parse($item->tgl_kembali)->format('d/m/Y'),
                    'jumlah_kembali' => $item->jumlah_kembali,
                    'kondisi' => ucfirst($item->kondisi),
                    'biaya_denda' => $item->biaya_denda > 0 ? 'Rp'.number_format($item->biaya_denda, 0, ',', '.') : '-',
                    'status' => ucfirst($item->status),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama Pengembali',
            'Barang',
            'Tanggal Kembali',
            'Jumlah',
            'Kondisi',
            'Denda',
            'Status',
        ];
    }
}