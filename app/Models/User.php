<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */

    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',

        'is_blocked',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    /**
     * Check if the user has a specific role using the 'role' column
     * This is a custom method that checks the role column directly
     * 
     * @param string $roleName
     * @return bool
     */
    public function hasRoleAttribute(string $roleName): bool
    {
        return $this->role === $roleName;
    }
    
    /**
     * Check if the user is an admin
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRoleAttribute('admin');
    }
    
    /**
     * Check if the user is a coach
     *
     * @return bool
     */
    public function isCoach(): bool
    {
        return $this->hasRoleAttribute('coach');
    }
    
    /**
     * Check if the user is a player
     *
     * @return bool
     */
    public function isPlayer(): bool
    {
        return $this->hasRoleAttribute('player');
    }

    public function coachProfile()
    {
        return $this->hasOne(CoachProfile::class);
    }

    public function nutritionalGoals()
    {
        return $this->hasMany(NutritionalGoal::class);
    }

    public function dietPlans()
    {
        return $this->hasMany(DietPlan::class);
    }

}
