<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('teknisi_mesin', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mesin_id'); // Pastikan bigInteger jika mesin.id juga bigInteger
            $table->unsignedBigInteger('teknisi_id'); // Jika ada teknisi_id

            // Definisi Foreign Key
            $table->foreign('mesin_id')->references('id')->on('mesin')->onDelete('cascade');
            $table->foreign('teknisi_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teknisi_mesin');
    }
};
