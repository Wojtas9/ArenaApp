<?php

namespace App\Providers;

use App\Models\DietPlan;
use App\Models\NutritionalGoal;
use App\Policies\DietPlanPolicy;
use App\Policies\NutritionalGoalPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        DietPlan::class => DietPlanPolicy::class,
        NutritionalGoal::class => NutritionalGoalPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}