<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::table('posts', function (Blueprint $table) {
        $table->unsignedBigInteger('file_id')->nullable();  // La columna file_id como foreign key
        $table->string('body', 255);  // La columna body para el texto del post
        $table->foreign('file_id')->references('id')->on('files');  // Definiendo la relación
    });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            //
        });
    }
};
