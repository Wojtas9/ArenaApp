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
        if (!Schema::hasTable('training_program_trainings')) {
            Schema::create('training_program_trainings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('training_program_id')->constrained()->onDelete('cascade');
                $table->foreignId('training_id')->constrained()->onDelete('cascade');
                $table->timestamps();
                $table->unique(['training_program_id', 'training_id'], 'tp_training_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_program_trainings');
    }
};