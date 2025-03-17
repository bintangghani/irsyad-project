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
        Schema::create('sub_kelompok', function (Blueprint $table) {
            $table->uuid('id_sub_kelompok')->primary()->unique();
            $table->string('nama');
            $table->uuid('id_kelompok');
            $table->foreign('id_kelompok')->references('id_kelompok')->on('kelompok')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_kelompok');
    }
};
