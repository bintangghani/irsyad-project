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
        Schema::create('role_permission', function (Blueprint $table) {
            $table->uuid('id_role_permission')->primary()->unique();
            $table->uuid('id_role');
            $table->foreign('id_role')->references('id_role')->on('role')->onUpdate('cascade')->onDelete('restrict');
            $table->uuid('id_permission');
            $table->foreign('id_permission')->references('id_permission')->on('permission')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permission');
    }
};
