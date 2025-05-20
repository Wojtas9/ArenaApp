<?php

namespace App\Policies;

use App\Models\NutritionalGoal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class NutritionalGoalPolicy
{
    use HandlesAuthorization;

    public function view(User $user, NutritionalGoal $nutritionalGoal)
    {
        return $user->id === $nutritionalGoal->user_id;
    }

    public function update(User $user, NutritionalGoal $nutritionalGoal)
    {
        return $user->id === $nutritionalGoal->user_id;
    }

    public function delete(User $user, NutritionalGoal $nutritionalGoal)
    {
        return $user->id === $nutritionalGoal->user_id;
    }
}