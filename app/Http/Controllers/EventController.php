<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Category;
use App\Models\Spot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Display a listing of events for the calendar.
     */
    public function index(Request $request)
    {
        $events = Event::with(['category', 'spot', 'instructor'])->get();
        
        // Transform events for FullCalendar format
        $calendarEvents = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_time->toIso8601String(),
                'end' => $event->end_time->toIso8601String(),
                'allDay' => $event->is_all_day,
                'backgroundColor' => $event->color ?? $event->category->color,
                'borderColor' => $event->color ?? $event->category->color,
                'extendedProps' => [
                    'description' => $event->description,
                    'category' => $event->category->name,
                    'category_id' => $event->category_id,
                    'spot' => $event->spot ? $event->spot->name : null,
                    'instructor' => $event->instructor ? $event->instructor->name : null,
                    'priority' => $event->priority,
                ]
            ];
        });
        
        return response()->json($calendarEvents);
    }

    /**
     * Store a newly created event.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'category_id' => 'required|exists:categories,id',
            'spot_id' => 'nullable|exists:spots,id',
            'instructor_id' => 'nullable|exists:users,id',
            'is_all_day' => 'boolean',
            'color' => 'nullable|string',
            'priority' => 'integer|min:0|max:3',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $event = new Event($request->all());
        $event->created_by = Auth::id();
        $event->save();

        return response()->json($event->load(['category', 'spot', 'instructor']), 201);
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        return response()->json($event->load(['category', 'spot', 'instructor', 'creator']));
    }

    /**
     * Update the specified event.
     */
    public function update(Request $request, Event $event)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'start_time' => 'date',
            'end_time' => 'date|after_or_equal:start_time',
            'category_id' => 'exists:categories,id',
            'spot_id' => 'nullable|exists:spots,id',
            'instructor_id' => 'nullable|exists:users,id',
            'is_all_day' => 'boolean',
            'color' => 'nullable|string',
            'priority' => 'integer|min:0|max:3',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $event->update($request->all());

        return response()->json($event->load(['category', 'spot', 'instructor']));
    }

    /**
     * Remove the specified event.
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json(null, 204);
    }
}