<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users');
            $table->foreignId('id_barang')->constrained('barangs');
            // $table->string('nama_peminjam');
            $table->string('alasan_pinjam');
            $table->string('jumlah');
            $table->date('tgl_pinjam');
            $table->date('tgl_kembali');
            $table->enum('status', ['pending', 'approved', 'rejected', 'returned'])->default('pending');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
