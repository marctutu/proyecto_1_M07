<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
    Schema::table('posts', function (Blueprint $table) {
        $table->unsignedBigInteger('author_id');
        $table->foreign('author_id')->references('id')->on('users');
    });
    }

    public function down()
    {
    Schema::table('posts', function (Blueprint $table) {
        $table->dropForeign(['author_id']);
        $table->dropColumn('author_id');
    });
    } 

};
