<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NutritionalGoal extends Model
{
    protected $fillable = [
        'user_id',
        'target_calories',
        'target_proteins',
        'target_carbohydrates',
        'target_fats',
        'start_date',
        'end_date',
        'status',
        'notes'
    ];

    protected $casts = [
        'target_calories' => 'integer',
        'target_proteins' => 'float',
        'target_carbohydrates' => 'float',
        'target_fats' => 'float',
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
