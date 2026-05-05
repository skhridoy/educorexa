<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('event_date', 'asc')->get();
        return view('super.events.index', compact('events'));
    }

    public function create()
    {
        return view('super.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'event_time' => 'nullable',
            'location' => 'nullable|string|max:255',
            'color' => 'required|in:blue,purple,green',
        ]);

        Event::create($request->all());

        return redirect()->back()->with('success', 'Event created successfully.');
    }

    public function edit(Event $event)
    {
        return view('super.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'event_time' => 'nullable',
            'location' => 'nullable|string|max:255',
            'color' => 'required|in:blue,purple,green',
        ]);

        $event->update($request->all());

        return redirect()->route('super.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->back()->with('success', 'Event deleted successfully.');
    }
}
