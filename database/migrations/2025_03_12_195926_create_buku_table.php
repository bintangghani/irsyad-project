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
        Schema::create('buku', function (Blueprint $table) {
            $table->uuid('id_buku')->primary()->unique();
            $table->string('penerbit');
            $table->text('alamat_penerbit');
            $table->string('judul');
            $table->year('tahun_terbit');
            $table->integer('jumlah_halaman');
            $table->text('sampul');
            $table->text('deskripsi');
            $table->text('file_buku');
            $table->integer('total_download');
            $table->integer('total_read');
            $table->uuid('uploaded_by');
            $table->foreign('uploaded_by')->references('id_user')->on('users')->onUpdate('cascade')->onDelete('restrict');
            $table->uuid('sub_kelompok');
            $table->foreign('sub_kelompok')->references('id_sub_kelompok')->on('sub_kelompok')->onUpdate('cascade')->onDelete('restrict');
            $table->uuid('jenis');
            $table->foreign('jenis')->references('id_jenis')->on('jenis')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku');
    }
};
