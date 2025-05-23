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
        Schema::create('nutritional_goals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('daily_calories_target');
            $table->decimal('daily_proteins_target', 8, 2);
            $table->decimal('daily_carbohydrates_target', 8, 2);
            $table->decimal('daily_fats_target', 8, 2);
            $table->decimal('daily_fiber_target', 8, 2)->nullable();
            $table->text('dietary_restrictions')->nullable();
            $table->text('notes')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->enum('status', ['active', 'completed', 'archived'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nutritional_goals');
    }
};
