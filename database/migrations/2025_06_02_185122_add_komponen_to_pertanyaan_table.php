<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pertanyaan', function (Blueprint $table) {
            $table->string('komponen')->nullable()->after('tindakan');
        });
    }

    public function down()
    {
        Schema::table('pertanyaan', function (Blueprint $table) {
            $table->dropColumn('komponen');
        });
    }
};
