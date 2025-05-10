<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
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
public function isAdminRole(): bool
    {
        return $this->hasRoleAttribute('admin');
    }
    
    /**
     * Check if the user is a coach
     *
     * @return bool
     */
    public function isCoachRole(): bool
    {
        return $this->hasRoleAttribute('coach');
    }
    
    /**
     * Check if the user is a player
     *
     * @return bool
     */
    public function isPlayerRole(): bool
    {
        return $this->hasRoleAttribute('player');
    }

    /**
     * Check if user is admin
     */
    /**
     * Check if the user is an admin
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is a coach
     *
     * @return bool
     */
    public function isCoach()
    {
        return $this->role === 'coach';
    }

    /**
     * Check if the user is a player
     *
     * @return bool
     */
    public function isPlayer()
    {
        return $this->role === 'player';
    }

    /**
     * Get messages sent by the user.
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Get messages received by the user.
     */
    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'recipient_id');
    }
}
