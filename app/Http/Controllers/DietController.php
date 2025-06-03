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
        $nutritionalGoals = NutritionalGoal::where('user_id', $user->id)->latest()->get();
        $dietPlans = DietPlan::where('user_id', $user->id)->with('meals.foodItems')->latest()->get();

        return view('diet.index', compact('nutritionalGoals', 'dietPlans'));
    }

    public function indexNutritionalGoals()
    {
        $user = Auth::user();
        $nutritionalGoals = NutritionalGoal::where('user_id', $user->id)->latest()->get();
        return view('diet.nutritional-goals.index', compact('nutritionalGoals'));
    }

    public function createNutritionalGoal()
    {
        return view('diet.nutritional-goals.create');
    }

    public function storeNutritionalGoal(Request $request)
    {
        $validated = $request->validate([
            'daily_calories_target' => 'required|integer|min:0',
            'daily_proteins_target' => 'required|numeric|min:0',
            'daily_carbohydrates_target' => 'required|numeric|min:0',
            'daily_fats_target' => 'required|numeric|min:0',
            'daily_fiber_target' => 'nullable|numeric|min:0',
            'dietary_restrictions' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'notes' => 'nullable|string'
        ]);

        $nutritionalGoal = NutritionalGoal::create(array_merge($validated, ['user_id' => Auth::id()]));

        return redirect()->route('diet.index')->with('success', 'Nutritional goal created successfully.');
    }

    public function updateNutritionalGoal(Request $request, NutritionalGoal $nutritionalGoal)
    {
if (Auth::id() !== $nutritionalGoal->user_id) {
    abort(403, 'Unauthorized action.');
}
        
        $validated = $request->validate([
            'daily_calories_target' => 'required|integer|min:0',
            'daily_proteins_target' => 'required|numeric|min:0',
            'daily_carbohydrates_target' => 'required|numeric|min:0',
            'daily_fats_target' => 'required|numeric|min:0',
            'daily_fiber_target' => 'nullable|numeric|min:0',
            'dietary_restrictions' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'notes' => 'nullable|string'
        ]);
    
        $nutritionalGoal->update($validated);
    
        return redirect()->route('diet.index')->with('success', 'Nutritional goal updated successfully.');
    }

    public function editNutritionalGoal(NutritionalGoal $nutritionalGoal)
    {
if (Auth::id() !== $nutritionalGoal->user_id) {
    abort(403, 'Unauthorized action.');
}
        return view('diet.nutritional-goals.edit', compact('nutritionalGoal'));
    }

    public function createDietPlan()
    {
        $nutritionalGoals = NutritionalGoal::where('user_id', Auth::id())->latest()->get();
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

        $dietPlan = DietPlan::create(array_merge($validated, ['user_id' => Auth::id()]));

        return redirect()->route('diet.index')->with('success', 'Diet plan created successfully.');
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
if (Auth::id() !== $dietPlan->user_id) {
    abort(403, 'Unauthorized action.');
}
        $nutritionalGoals = NutritionalGoal::where('user_id', Auth::id())->latest()->get();
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