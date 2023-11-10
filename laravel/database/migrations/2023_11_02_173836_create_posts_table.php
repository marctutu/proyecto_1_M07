<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // bigint(20) y autoincremento
            $table->string('body', 255); // varchar(255)
            $table->unsignedBigInteger('file_id')->nullable(); // bigint(20), nullable
            $table->float('latitude'); // float
            $table->float('longitude'); // float
            $table->unsignedBigInteger('author_id'); // bigint(20)
            $table->timestamps(); // timestamp con valor por defecto al tiempo actual
            // Si necesitas también la columna updated_at, puedes usar $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
