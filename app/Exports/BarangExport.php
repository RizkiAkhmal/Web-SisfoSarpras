<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BarangExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Barang::select('nama_barang', 'jumlah_barang', 'id_kategori')
            ->with('kategoris')
            ->get()
            ->map(function ($item) {
                return [
                    'nama_barang' => $item->nama_barang,
                    'jumlah_barang' => $item->jumlah_barang,
                    'kategori' => $item->kategoris->nama_kategori ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama Barang',
            'Jumlah Barang',
            'Kategori',
        ];
    }
}