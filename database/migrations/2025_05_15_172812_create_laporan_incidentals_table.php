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
        Schema::create('LaporanIncidental', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mesin_id')->constrained('mesins')->onDelete('cascade');
            $table->foreignId('station_id')->constrained()->onDelete('cascade');
            $table->text('description');
            $table->string('photo_path')->nullable();
            $table->boolean('requires_spare_part')->default(false);
            $table->foreignId('spare_part_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_incidentals');
    }
};
