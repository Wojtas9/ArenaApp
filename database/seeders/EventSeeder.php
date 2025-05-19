<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Category;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing events
        DB::table('events')->truncate();
        
        // Get category IDs for reference
        $categories = Category::all();
        
        // Get a coach user ID for instructor reference
        $instructor = User::role('coach')->first() ?? User::first();
        
        // Create sample events
        $events = [
            // Volleyball events
            [
                'title' => 'Volleyball Training',
                'description' => 'Regular volleyball training session for the team',
                'start_time' => Carbon::now()->setTime(10, 0)->toDateTimeString(),
                'end_time' => Carbon::now()->setTime(12, 0)->toDateTimeString(),
                'category_id' => $categories->where('name', 'Volleyball')->first()->id ?? 1,
                'instructor_id' => $instructor->id,
                'created_by' => 1,
                'is_all_day' => false,                
            ],
            [
                'title' => 'Volleyball Match',
                'description' => 'Competitive match against rival team',
                'start_time' => Carbon::now()->addDays(2)->setTime(15, 0)->toDateTimeString(),
                'end_time' => Carbon::now()->addDays(2)->setTime(17, 0)->toDateTimeString(),
                'category_id' => $categories->where('name', 'Volleyball')->first()->id ?? 1,
                'instructor_id' => $instructor->id,
                'created_by' => 1,
                'is_all_day' => false,                
            ],
            
            // Football events
            [
                'title' => 'Football Practice',
                'description' => 'Weekly football practice session',
                'start_time' => Carbon::now()->addDay()->setTime(14, 0)->toDateTimeString(),
                'end_time' => Carbon::now()->addDay()->setTime(16, 0)->toDateTimeString(),
                'category_id' => $categories->where('name', 'Football')->first()->id ?? 2,
                'instructor_id' => $instructor->id,
                'created_by' => 1,
                'is_all_day' => false,                
            ],
            [
                'title' => 'Football Tournament',
                'description' => 'All-day football tournament with multiple teams',
                'start_time' => Carbon::now()->addDays(5)->startOfDay()->toDateTimeString(),
                'end_time' => Carbon::now()->addDays(5)->endOfDay()->toDateTimeString(),
                'category_id' => $categories->where('name', 'Football')->first()->id ?? 2,
                'instructor_id' => $instructor->id,
                'created_by' => 1,
                'is_all_day' => true,                
            ],
            
            // Basketball events
            [
                'title' => 'Basketball Training',
                'description' => 'Basketball skills and drills session',
                'start_time' => Carbon::now()->addDays(3)->setTime(9, 0)->toDateTimeString(),
                'end_time' => Carbon::now()->addDays(3)->setTime(11, 0)->toDateTimeString(),
                'category_id' => $categories->where('name', 'Basketball')->first()->id ?? 3,
                'instructor_id' => $instructor->id,
                'created_by' => 1,
                'is_all_day' => false,                
            ],
            [
                'title' => 'Basketball Game',
                'description' => 'Championship basketball game',
                'start_time' => Carbon::now()->addDays(7)->setTime(18, 0)->toDateTimeString(),
                'end_time' => Carbon::now()->addDays(7)->setTime(20, 0)->toDateTimeString(),
                'category_id' => $categories->where('name', 'Basketball')->first()->id ?? 3,
                'instructor_id' => $instructor->id,
                'created_by' => 1,
                'is_all_day' => false,                
            ],
        ];
        
        foreach ($events as $event) {
            Event::create($event);
        }
    }
}