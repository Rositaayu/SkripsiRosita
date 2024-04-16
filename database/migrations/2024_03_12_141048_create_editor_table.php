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
        Schema::create('editor', function (Blueprint $table) {
            $table->id('id_editor');
            $table->unsignedBigInteger('id_user')->index();
            $table->string('alamat');
            $table->string('no_hp')->unique();
            $table->foreign('id_user')->references('id_user')->on('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editor');
    }
};
