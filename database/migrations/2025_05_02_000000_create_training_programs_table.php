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
        if (!Schema::hasTable('training_programs')) {
            Schema::create('training_programs', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->text('description')->nullable();
                $table->foreignId('coach_id')->constrained('users');
                $table->enum('status', ['active', 'completed', 'cancelled'])->default('active');
                $table->text('todo_list')->nullable(); 
                $table->integer('total_sessions')->default(0);
                $table->timestamps();
            });
        }

        // Only try to modify the trainings table if it exists
        if (Schema::hasTable('trainings')) {
            Schema::table('trainings', function (Blueprint $table) {
                if (!Schema::hasColumn('trainings', 'program_id')) {
                    $table->foreignId('program_id')->nullable()->constrained('training_programs')->onDelete('cascade');
                }
                if (!Schema::hasColumn('trainings', 'session_number')) {
                    $table->integer('session_number')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('trainings')) {
            Schema::table('trainings', function (Blueprint $table) {
                $table->dropForeign(['program_id']);
                $table->dropColumn(['program_id', 'session_number']);
            });
        }

        Schema::dropIfExists('training_programs');
    }
};