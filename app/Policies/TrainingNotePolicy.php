<?php

namespace App\Policies;

use App\Models\TrainingNote;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TrainingNotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'player';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TrainingNote $trainingNote): bool
    {
        return $user->id === $trainingNote->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
       
        return $user->hasRole('player');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TrainingNote $trainingNote): bool
    {
        return $user->id === $trainingNote->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TrainingNote $trainingNote): bool
    {
        return $user->id === $trainingNote->user_id;
    }
}