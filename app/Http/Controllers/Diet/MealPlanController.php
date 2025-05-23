<?php

namespace App\Http\Controllers\Diet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MealPlan;
use Illuminate\Support\Facades\Auth;

class MealPlanController extends Controller
{
    /**
     * Display a listing of the meal plans.
     */
    public function index()
    {
        $mealPlans = Auth::user()->mealPlans()->get();
        return view('diet.meal_plans.index', compact('mealPlans'));
    }

    /**
     * Show the form for creating a new meal plan.
     */
    public function create()
    {
        return view('diet.meal_plans.create');
    }

    /**
     * Store a newly created meal plan in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Auth::user()->mealPlans()->create($request->all());

        return redirect()->route('meal-plans.index')->with('success', 'Meal Plan created successfully.');
    }

    /**
     * Display the specified meal plan.
     */
    public function show(MealPlan $mealPlan)
    {
        // Ensure the authenticated user owns the meal plan
        if (Auth::id() !== $mealPlan->user_id) {
            abort(403);
        }

        $mealPlan->load('meals.foodItems'); // Load related meals and food items

        return view('diet.meal_plans.show', compact('mealPlan'));
    }

    /**
     * Show the form for editing the specified meal plan.
     */
    public function edit(MealPlan $mealPlan)
    {
        // Ensure the authenticated user owns the meal plan
        if (Auth::id() !== $mealPlan->user_id) {
            abort(403);
        }

        return view('diet.meal_plans.edit', compact('mealPlan'));
    }

    /**
     * Update the specified meal plan in storage.
     */
    public function update(Request $request, MealPlan $mealPlan)
    {
        // Ensure the authenticated user owns the meal plan
        if (Auth::id() !== $mealPlan->user_id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $mealPlan->update($request->all());

        return redirect()->route('meal-plans.index')->with('success', 'Meal Plan updated successfully.');
    }

    /**
     * Remove the specified meal plan from storage.
     */
    public function destroy(MealPlan $mealPlan)
    {
        // Ensure the authenticated user owns the meal plan
        if (Auth::id() !== $mealPlan->user_id) {
            abort(403);
        }

        $mealPlan->delete();

        return redirect()->route('meal-plans.index')->with('success', 'Meal Plan deleted successfully.');
    }
}