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
        Schema::create('berita', function (Blueprint $table) {
            $table->id('id_berita');
            $table->unsignedBigInteger('id_kategori_berita')->index();
            $table->unsignedBigInteger('id_user')->index();
            $table->string('judul_berita');
            $table->string('foto_berita');
            $table->string('caption_foto');
            $table->text('artikel_berita');
            $table->tinyInteger('status_berita')->default(0)->comment('0 = Review, 1 = Pending, 2 = On Progress, 3 = Published');
            $table->foreign('id_kategori_berita')->references('id_kategori_berita')->on('kategori_berita');
            $table->foreign('id_user')->references('id_user')->on('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
