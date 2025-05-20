<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = [
        'diet_plan_id',
        'name',
        'description',
        'scheduled_time',
        'calories',
        'proteins',
        'carbohydrates',
        'fats'
    ];

    protected $casts = [
        'scheduled_time' => 'datetime',
        'calories' => 'integer',
        'proteins' => 'float',
        'carbohydrates' => 'float',
        'fats' => 'float'
    ];

    public function dietPlan()
    {
        return $this->belongsTo(DietPlan::class);
    }

    public function foodItems()
    {
        return $this->hasMany(FoodItem::class);
    }
}
