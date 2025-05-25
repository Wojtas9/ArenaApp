<?php

namespace App\Http\Controllers\Diet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Meal;
use App\Models\MealPlan;
use Illuminate\Support\Facades\Auth;

class MealController extends Controller
{
    /**
     * Show the form for creating a new meal for a meal plan.
     */
    public function create(MealPlan $mealPlan)
    {
        // Ensure the authenticated user owns the meal plan
        if (Auth::id() !== $mealPlan->user_id) {
            abort(403);
        }

        return view('diet.meals.create', compact('mealPlan'));
    }

    /**
     * Store a newly created meal in storage.
     */
    public function store(Request $request, MealPlan $mealPlan)
    {
        // Ensure the authenticated user owns the meal plan
        if (Auth::id() !== $mealPlan->user_id) {
            abort(403);
        }

        $request->validate([
            'day' => 'required|date',
            'type' => 'required|string|in:breakfast,lunch,dinner,snack',
        ]);

        $mealPlan->meals()->create($request->all());

        return redirect()->route('meal-plans.show', $mealPlan)->with('success', 'Meal added successfully.');
    }

    /**
     * Remove the specified meal from storage.
     */
    public function destroy(Meal $meal)
    {
        // Ensure the authenticated user owns the meal plan associated with the meal
        if (Auth::id() !== $meal->mealPlan->user_id) {
            abort(403);
        }

        $meal->delete();

        return redirect()->route('meal-plans.show', $meal->meal_plan_id)->with('success', 'Meal deleted successfully.');
    }
}