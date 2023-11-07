<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLatitudeLongitudeToPostsTable extends Migration
{
    public function up()
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->float('latitude')->nullable()->after('file_id');
            $table->float('longitude')->nullable()->after('latitude');
            $table->dropColumn('updated_at');
        });
    }

    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {
            // Si se revierte la migración, simplemente remueve las columnas latitude y longitude
            $table->dropColumn(['latitude', 'longitude']);
            // La columna updated_at se elimina permanentemente, no se re-añade
        });
    }
}


