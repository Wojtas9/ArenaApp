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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->foreignId('category_id')->constrained();
            $table->foreignId('spot_id')->nullable()->constrained();
            $table->foreignId('instructor_id')->nullable()->constrained('users');
            $table->foreignId('created_by')->constrained('users');
            $table->boolean('is_all_day')->default(false);
            $table->string('color')->nullable();
            $table->integer('priority')->default(0); // For prioritization features
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};