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
        Schema::create('wartawan', function (Blueprint $table) {
            $table->id('id_wartawan');
            $table->unsignedBigInteger('id_user')->index();
            $table->unsignedBigInteger('id_editor')->index();
            $table->foreign('id_user')->references('id_user')->on('user');
            $table->foreign('id_editor')->references('id_editor')->on('editor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wartawan');
    }
};
