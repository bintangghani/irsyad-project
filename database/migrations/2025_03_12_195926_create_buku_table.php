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
            $table->string('no_isbn')->nullable();
            $table->string('penulis');
            $table->string('penerbit');
            $table->text('alamat_penerbit')->nullable();
            $table->string('judul');
            $table->year('tahun_terbit');
            $table->integer('jumlah_halaman');
            $table->text('sampul')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('file_buku')->nullable();
            $table->integer('total_download')->default(0);
            $table->integer('total_read')->default(0);
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