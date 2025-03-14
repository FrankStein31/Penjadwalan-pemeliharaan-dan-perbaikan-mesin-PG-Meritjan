<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('jadwal_pemeliharaan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mesin_id')->constrained('mesin')->onDelete('cascade');
            $table->foreignId('teknisi_id')->constrained('users')->onDelete('cascade'); // User dengan role teknisi
            $table->enum('jenis', ['rutin', 'incidental']);
            $table->date('tanggal');
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['Terjadwal', 'Selesai', 'Dibatalkan'])->default('Terjadwal');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('jadwal_pemeliharaan');
    }
};
