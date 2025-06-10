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
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pengembali');
            $table->integer('jumlah_kembali');
            $table->date('tgl_kembali');
            $table->enum('status',['pending', 'complete', 'damage'])->default('pending');
            $table->enum('kondisi', ['baik', 'rusak', 'hilang']); 
            $table->decimal('biaya_denda', 12, 2)->default(0); // Increased to allow up to 10 million
            $table->timestamps();
            
            $table->foreignId('id_peminjaman')->references('id')->on('peminjamans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};

