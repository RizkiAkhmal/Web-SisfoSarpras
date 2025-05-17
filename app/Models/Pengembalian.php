<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'pengembalians';

    protected $fillable = [
        'id_peminjaman',
        'nama_pengembali',
        'tgl_kembali',
        'jumlah_kembali',
        'kondisi',
        'biaya_denda',
        'status'
    ];

    public function peminjaman(){
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman');
    }
    
    /**
     * Menghitung keterlambatan dan denda jika ada
     */
    public function hitungKeterlambatan()
    {
        // Pastikan relasi peminjaman sudah dimuat
        if (!$this->relationLoaded('peminjaman')) {
            $this->load('peminjaman');
        }
        
        if ($this->peminjaman) {
            // Ambil tanggal pengembalian yang diharapkan dari peminjaman
            $tanggalHarusKembali = Carbon::parse($this->peminjaman->tgl_kembali);
            $tanggalDikembalikan = Carbon::parse($this->tgl_kembali);
            
            // Hitung jumlah hari terlambat
            $hariTerlambat = $tanggalDikembalikan->greaterThan($tanggalHarusKembali) 
                ? $tanggalDikembalikan->diffInDays($tanggalHarusKembali) 
                : 0;
                
            // Jika terlambat dan belum ada denda yang ditetapkan
            if ($hariTerlambat > 0 && $this->biaya_denda <= 0) {
                // Contoh: denda Rp 5000 per hari per barang
                $tarifDenda = 5000; 
                $totalDenda = $hariTerlambat * $tarifDenda * $this->jumlah_kembali;
                
                // Update denda
                $this->biaya_denda = $totalDenda;
                $this->save();
            }
        }
        
        return $this;
    }
}
