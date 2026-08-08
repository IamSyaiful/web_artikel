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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('poster')->nullable();
            $table->date('release_date')->nullable();
            $table->unsignedSmallInteger('duration')->nullable();
            $table->string('director')->nullable();
            $table->decimal('rating', 2, 1)->default(0.0);
            $table->text('synopsis')->nullable();
            $table->longText('review')->nullable();
            $table->timestamps();
            $table->index('title');
            $table->index('release_date');
            $table->index('rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
