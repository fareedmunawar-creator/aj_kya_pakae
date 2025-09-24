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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('title');
            $table->text('description');
            $table->text('instructions');
            $table->string('image_path')->nullable();
            $table->integer('cooking_time');
            $table->integer('servings')->nullable();
            $table->enum('difficulty', ['easy', 'medium', 'hard'])->default('medium');
        
            $table->unsignedBigInteger('user_id'); // Explicit
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        
            $table->timestamps();
        });
        
        
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};