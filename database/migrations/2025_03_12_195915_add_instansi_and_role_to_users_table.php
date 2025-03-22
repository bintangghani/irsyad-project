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
        Schema::table('users', function (Blueprint $table) {
            $table->uuid('id_role');
            $table->foreign('id_role')->references('id_role')->on('role')->onUpdate('cascade')->onDelete('restrict');
            $table->uuid('id_instansi')->nullable();
            $table->foreign('id_instansi')->references('id_instansi')->on('instansi')->onUpdate('cascade')->onDelete('restrict');
        });
    }
};
