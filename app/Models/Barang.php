<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_kategori',
        'nama_barang',
        'jumlah_barang',
        'foto'
    ];
    
     
    public function kategoris(){
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }
}
