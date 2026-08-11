<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movie_submission_genre', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_submission_id')->constrained('movie_submissions')->cascadeOnDelete();
            $table->foreignId('genre_id')->constrained('genres')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['movie_submission_id', 'genre_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movie_submission_genre');
    }
};
