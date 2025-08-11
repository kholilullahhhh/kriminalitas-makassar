<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('clusters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_kriminal_id')->constrained()->onDelete('cascade');
            $table->integer('cluster'); // 0,1,2
            $table->decimal('nilai', 10, 4)->nullable();
            $table->enum('kategori', ['Tinggi', 'Sedang', 'Rendah']);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('clusters');
    }
};
