<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NutritionalGoal extends Model
{
    protected $fillable = [
        'user_id',
        'daily_calories_target',
        'daily_proteins_target',
        'daily_carbohydrates_target',
        'daily_fats_target',
        'daily_fiber_target',
        'dietary_restrictions',
        'start_date',
        'end_date',
        'status',
        'notes'
    ];

    protected $casts = [
        'daily_calories_target' => 'integer',
        'daily_proteins_target' => 'float',
        'daily_carbohydrates_target' => 'float',
        'daily_fats_target' => 'float',
        'daily_fiber_target' => 'float',
        'start_date' => 'date',
        'end_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dietPlans()
    {
        return $this->hasMany(DietPlan::class);
    }
}
