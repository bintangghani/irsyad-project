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
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->uuid('id_bookmarks')->primary()->unique();
            $table->uuid('id_user');
            $table->foreign('id_user')->references('id_user')->on('users')->onUpdate('cascade')->onDelete('restrict');
            $table->uuid('id_buku');
            $table->foreign('id_buku')->references('id_buku')->on('buku')->onUpdate('cascade')->onDelete('restrict');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};
