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
        Schema::create('bgg_games', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('year_published')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('image')->nullable();
            $table->json('alternate_names')->nullable(); // Nowa kolumna dla nazw alternatywnych
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bgg_games');
    }
};
