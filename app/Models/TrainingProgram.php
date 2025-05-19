<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'coach_id',
        'status',
        'total_sessions',
        'todo_list', 
    ];

    public function coach()
    {
        return $this->belongsTo(User::class, 'coach_id');
    }
    
    protected $casts = [
        'todo_list' => 'array',
    ];
}