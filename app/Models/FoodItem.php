<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model
{
    protected $fillable = [
        'meal_id',
        'name',
        'portion_size',
        'unit',
        'calories',
        'proteins',
        'carbohydrates',
        'fats',
        'notes'
    ];

    protected $casts = [
        'portion_size' => 'float',
        'calories' => 'integer',
        'proteins' => 'float',
        'carbohydrates' => 'float',
        'fats' => 'float'
    ];

    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }
}
