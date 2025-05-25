<?php

namespace App\Http\Controllers\Diet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FoodItem;
use App\Models\Meal;
use Illuminate\Support\Facades\Auth;

class FoodItemController extends Controller
{
    /**
     * Show the form for creating a new food item for a meal.
     */
    public function create(Meal $meal)
    {
        // Ensure the authenticated user owns the meal plan associated with the meal
        if (Auth::id() !== $meal->mealPlan->user_id) {
            abort(403);
        }

        return view('diet.food_items.create', compact('meal'));
    }

    /**
     * Store a newly created food item in storage.
     */
    public function store(Request $request, Meal $meal)
    {
        // Ensure the authenticated user owns the meal plan associated with the meal
        if (Auth::id() !== $meal->mealPlan->user_id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:255',
        ]);

        $meal->foodItems()->create($request->all());

        return redirect()->route('meal-plans.show', $meal->meal_plan_id)->with('success', 'Food item added successfully.');
    }

    /**
     * Remove the specified food item from storage.
     */
    public function destroy(FoodItem $foodItem)
    {
        // Ensure the authenticated user owns the meal plan associated with the food item's meal
        if (Auth::id() !== $foodItem->meal->mealPlan->user_id) {
            abort(403);
        }

        $foodItem->delete();

        return redirect()->route('meal-plans.show', $foodItem->meal->meal_plan_id)->with('success', 'Food item deleted successfully.');
    }
}