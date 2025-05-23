<?php

namespace App\Http\Controllers;

use App\Models\DietPlan;
use App\Models\NutritionalGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DietController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $user = Auth::user();
        $nutritionalGoals = $user->nutritionalGoals()->latest()->get();
        $dietPlans = $user->dietPlans()->with('meals.foodItems')->latest()->get();

        return view('diet.index', compact('nutritionalGoals', 'dietPlans'));
    }

    public function indexNutritionalGoals()
    {
        $user = Auth::user();
        $nutritionalGoals = $user->nutritionalGoals()->latest()->get();
        return view('diet.nutritional-goals.index', compact('nutritionalGoals'));
    }

    public function createNutritionalGoal()
    {
        return view('diet.nutritional-goals.create');
    }

    public function storeNutritionalGoal(Request $request)
    {
        $validated = $request->validate([
            'target_calories' => 'required|integer|min:0',
            'target_proteins' => 'required|numeric|min:0',
            'target_carbohydrates' => 'required|numeric|min:0',
            'target_fats' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'notes' => 'nullable|string'
        ]);

        $nutritionalGoal = Auth::user()->nutritionalGoals()->create($validated);

        return redirect()->route('diet.index')->with('success', 'Nutritional goal created successfully.');
    }

    public function editNutritionalGoal(NutritionalGoal $nutritionalGoal)
    {
        $this->authorize('update', $nutritionalGoal);
        return view('diet.nutritional-goals.edit', compact('nutritionalGoal'));
    }

    public function createDietPlan()
    {
        $nutritionalGoals = Auth::user()->nutritionalGoals()->latest()->get();
        return view('diet.diet-plans.create', compact('nutritionalGoals'));
    }

    public function storeDietPlan(Request $request)
    {
        $validated = $request->validate([
            'nutritional_goal_id' => 'required|exists:nutritional_goals,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date'
        ]);

        $dietPlan = Auth::user()->dietPlans()->create($validated);

        return redirect()->route('diet.index')->with('success', 'Diet plan created successfully.');
    }

    public function updateNutritionalGoal(Request $request, NutritionalGoal $nutritionalGoal)
    {
        $this->authorize('update', $nutritionalGoal);

        $validated = $request->validate([
            'target_calories' => 'required|integer|min:0',
            'target_proteins' => 'required|numeric|min:0',
            'target_carbohydrates' => 'required|numeric|min:0',
            'target_fats' => 'required|numeric|min:0',
            'end_date' => 'nullable|date|after:start_date',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,completed,archived'
        ]);

        $nutritionalGoal->update($validated);

        return redirect()->route('diet.index')->with('success', 'Nutritional goal updated successfully.');
    }

    public function indexDietPlans()
    {
        $user = Auth::user();
        $dietPlans = $user->dietPlans()->with('meals.foodItems')->latest()->get();
        return view('diet.diet-plans.index', compact('dietPlans'));
    }

    public function updateDietPlan(Request $request, DietPlan $dietPlan)
    {
        $this->authorize('update', $dietPlan);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'end_date' => 'nullable|date|after:start_date',
            'status' => 'required|in:active,completed,archived'
        ]);

        $dietPlan->update($validated);

        return redirect()->route('diet.index')->with('success', 'Diet plan updated successfully.');
    }

    public function editDietPlan(DietPlan $dietPlan)
    {
        $this->authorize('update', $dietPlan);
        $nutritionalGoals = Auth::user()->nutritionalGoals()->latest()->get();
        return view('diet.diet-plans.edit', compact('dietPlan', 'nutritionalGoals'));
    }

    public function deleteDietPlan(DietPlan $dietPlan)
    {
        $this->authorize('delete', $dietPlan);
        $dietPlan->delete();

        return redirect()->route('diet.index')->with('success', 'Diet plan deleted successfully.');
    }

    public function deleteNutritionalGoal(NutritionalGoal $nutritionalGoal)
    {
        $this->authorize('delete', $nutritionalGoal);
        $nutritionalGoal->delete();

        return redirect()->route('diet.index')->with('success', 'Nutritional goal deleted successfully.');
    }
}