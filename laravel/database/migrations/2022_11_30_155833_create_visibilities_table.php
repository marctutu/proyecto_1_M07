<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Visibility;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('visibilities', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->timestamps();
        });

        // Call seeder
        Artisan::call('db:seed', [
            '--class' => 'VisibilitySeeder',
            '--force' => true // <--- add this line
        ]);

        // Update posts and places table
        foreach (['posts', 'places'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->unsignedBigInteger('visibility_id')
                    ->default(Visibility::PUBLIC)
                    ->after('author_id');
                $table->foreign('visibility_id')
                    ->references('id')->on('visibilities')
                    ->cascadeOnUpdate()
                    ->restrictOnDelete();
            });
        }

        // Update old users with default visibility
        DB::update(
            "UPDATE places
             SET visibility_id = " . Visibility::PUBLIC . "
             WHERE visibility_id IS NULL",
        );        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Update posts and places table
        foreach (['posts', 'places'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropForeign(['visibility_id']);
                $table->dropColumn('visibility_id');
            });
        }

        Schema::dropIfExists('visibilities');
    }
};
