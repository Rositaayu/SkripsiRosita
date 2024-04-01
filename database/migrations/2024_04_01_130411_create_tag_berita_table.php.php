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
        Schema::create('tag_berita', function (Blueprint $table) {
            $table->id('id_tag_berita');
            $table->unsignedBigInteger('id_berita')->index();
            $table->unsignedBigInteger('id_tag')->index();
            $table->foreign('id_berita')->references('id_berita')->on('berita');
            $table->foreign('id_tag')->references('id_tag')->on('tag');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_berita');
    }
};
