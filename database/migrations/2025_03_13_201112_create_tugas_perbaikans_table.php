<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tugas_perbaikan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mesin_id');
            $table->unsignedBigInteger('user_id'); // User sebagai teknisi
            $table->date('tanggal_penugasan');
            $table->string('status')->default('Diterima'); // Status: Diterima, Selesai, Dibatalkan
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('mesin_id')->references('id')->on('mesins')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Menggunakan user_id
        });
    }

    public function down()
    {
        Schema::dropIfExists('tugas_perbaikan');
    }
};
