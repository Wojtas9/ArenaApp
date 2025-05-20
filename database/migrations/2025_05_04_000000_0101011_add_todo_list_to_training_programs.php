<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Check if column exists using a direct query instead of Schema::hasColumn
        $columns = DB::select("SHOW COLUMNS FROM `training_programs` LIKE 'todo_list'");
        
        if (empty($columns)) {
            Schema::table('training_programs', function (Blueprint $table) {
                $table->text('todo_list')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_programs', function (Blueprint $table) {
            $table->dropColumn('todo_list');
        });
    }
};