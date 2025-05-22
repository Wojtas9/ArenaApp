<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'photo',
        'description',
        'specialty',
        'favorite_halls',
        'accessibility',
    ];

    /**
     * Get the user that owns the coach profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}