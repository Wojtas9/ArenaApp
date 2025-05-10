<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'location',
        'capacity',
        'description',
        'picture',
    ];

    /**
     * Get the user that created the spot.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}