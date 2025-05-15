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
        // Drop the pivot table first (foreign key constraint)
        Schema::dropIfExists('training_participants');
        Schema::dropIfExists('training_program_trainings');
        
        // Then drop the main table
        Schema::dropIfExists('trainings');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is a destructive migration, so the down method would need to recreate
        // the tables with their original structure if you want to be able to roll back
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->unsignedBigInteger('spot_id');
            $table->foreign('spot_id')->references('id')->on('spots');
            $table->unsignedBigInteger('coach_id');
            $table->foreign('coach_id')->references('id')->on('users');
            $table->integer('max_participants')->default(10);
            $table->decimal('price', 8, 2)->default(0);
            $table->enum('status', ['scheduled', 'cancelled', 'completed'])->default('scheduled');
            $table->timestamps();
        });
        
        Schema::create('training_participants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            
            $table->foreign('training_id')->references('id')->on('trainings')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::create('training_program_trainings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_program_id');
            $table->unsignedBigInteger('training_id');
            $table->timestamps();
            
            $table->foreign('training_program_id')->references('id')->on('training_programs')->onDelete('cascade');
            $table->foreign('training_id')->references('id')->on('trainings')->onDelete('cascade');
        });
    }
};