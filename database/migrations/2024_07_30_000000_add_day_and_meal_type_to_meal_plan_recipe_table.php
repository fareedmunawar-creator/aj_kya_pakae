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
        Schema::table('meal_plan_recipe', function (Blueprint $table) {
            $table->string('day')->nullable()->after('recipe_id');
            $table->string('meal_type')->nullable()->after('day');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meal_plan_recipe', function (Blueprint $table) {
            $table->dropColumn(['day', 'meal_type']);
        });
    }
};