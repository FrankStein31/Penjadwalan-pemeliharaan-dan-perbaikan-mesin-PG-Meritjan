<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('screenings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mesin_id')->constrained('mesins')->onDelete('cascade'); // Relasi ke tabel mesins
            $table->foreignId('teknisi_id')->constrained('users')->onDelete('cascade'); // Relasi ke teknisi (users)
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade'); // Relasi ke admin (users)
            $table->date('tanggal_pemeriksaan'); // Tanggal pemeriksaan
            $table->enum('status_operasional', ['Normal', 'Tidak Normal']); // Status mesin
            $table->string('kode_error')->nullable(); // Kode error (jika ada)
            $table->boolean('suara_anomali')->default(false); // Suara tidak normal?
            $table->boolean('getaran_berlebih')->default(false); // Getaran berlebih?
            $table->boolean('kebocoran')->default(false); // Kebocoran oli/cairan?
            $table->date('terakhir_perawatan')->nullable(); // Terakhir dirawat
            $table->enum('tindakan_rekomendasi', ['Lanjut Operasi', 'Perbaikan', 'Penggantian Komponen']); // Rekomendasi teknisi
            $table->text('catatan')->nullable(); // Catatan tambahan
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('screenings');
    }
};
