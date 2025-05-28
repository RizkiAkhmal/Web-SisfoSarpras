<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PeminjamanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Peminjaman::with(['user', 'barang'])
            ->get()
            ->map(function ($item) {
                return [
                    'nama_user' => $item->user->name ?? '-',
                    'barang' => $item->barang->nama_barang ?? '-',
                    'jumlah' => $item->jumlah,
                    'alasan' => $item->alasan_pinjam,
                    'tgl_pinjam' => $item->tgl_pinjam,
                    'tgl_kembali' => $item->tgl_kembali,
                    'status' => ucfirst($item->status),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama Akun',
            'Barang',
            'Jumlah',
            'Alasan',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Status',
        ];
    }
}