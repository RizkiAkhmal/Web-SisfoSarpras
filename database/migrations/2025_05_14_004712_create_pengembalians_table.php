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
            $table->foreignId('id_peminjaman')->constrained('peminjamans');
            $table->string('nama_pengembali');
            $table->integer('jumlah_kembali');
            $table->date('tgl_kembali');
            $table->enum('status',['pending', 'complete', 'damage'])->default('pending');
            $table->decimal('damage', 9, 3)->default(0);
            $table->timestamps();
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
