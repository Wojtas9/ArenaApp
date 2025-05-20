<?php

namespace App\Policies;

use App\Models\DietPlan;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DietPlanPolicy
{
    use HandlesAuthorization;

    public function view(User $user, DietPlan $dietPlan)
    {
        return $user->id === $dietPlan->user_id;
    }

    public function update(User $user, DietPlan $dietPlan)
    {
        return $user->id === $dietPlan->user_id;
    }

    public function delete(User $user, DietPlan $dietPlan)
    {
        return $user->id === $dietPlan->user_id;
    }
}