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
        Schema::create('pertanyaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jadwal_pemeliharaan_id')->constrained()->onDelete('cascade');
            $table->string('getaran');
            $table->string('suara');
            $table->string('pelumasan');
            $table->string('bocor');
            $table->string('kerusakan');
            $table->string('tindakan'); // Lanjut Operasi, Perbaikan, dll
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan');
    }
};
