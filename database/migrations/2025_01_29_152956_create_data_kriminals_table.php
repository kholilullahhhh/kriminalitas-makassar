<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('data_kriminals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kecamatan_id')->constrained()->onDelete('cascade');
            $table->year('tahun');
            $table->integer('tipu_online')->default(0);
            $table->integer('pencurian')->default(0);
            $table->integer('curanmor')->default(0);
            $table->integer('penipuan')->default(0);
            $table->integer('kdrt')->default(0);
            $table->integer('jumlah_penduduk');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('data_kriminals');
    }
};
