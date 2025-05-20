<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DietLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'meal_type',
        'food',
        'calories',
        'protein',
        'carbs',
        'fat',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}