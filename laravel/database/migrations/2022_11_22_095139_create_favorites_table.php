<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id()->first();            
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->unsignedBigInteger('place_id');
            $table->foreign('place_id')
                  ->references('id')->on('places')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            // Eloquent does not support composite PK :-(
            // $table->primary(['user_id', 'place_id']);
            // Eloquent compatibility workaround :-)
            $table->unique(['user_id', 'place_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorites');
    }
};
