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
        Schema::create('request_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teknisi_id')->constrained('users')->onDelete('cascade'); // assuming teknisi pakai users table
            $table->foreignId('spare_part_id')->constrained('spare_parts')->onDelete('cascade');
            $table->string('jumlah')->nullable(); // jumlah suku cadang yang diminta
            $table->text('keterangan')->nullable(); // keterangan tambahan
            $table->string('status')->default('Pending'); // Pending, Disetujui, Ditolak
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_parts');
    }
};
