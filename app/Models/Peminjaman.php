<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans';

    protected $fillable = [
        'id_user',
        'id_barang',
        // 'nama_peminjam',
        'alasan_pinjam',
        'jumlah',
        'tgl_pinjam',
        'tgl_kembali',
        'status'
    ];

    public function barang(){
        return $this->belongsTo(Barang::class, 'id_barang');
    }

    public function user(){
        return $this->belongsTo(User::class, 'id_user');
    }
}
