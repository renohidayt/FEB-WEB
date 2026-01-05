<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('start_date', 'desc')->paginate(20);
        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required|string|max:255',
            'organizer' => 'required|string|max:255',
            'participants' => 'nullable|string|max:255',
            'url' => 'nullable|url',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'keywords' => 'nullable|string',
            'description' => 'required',
            'status' => 'required|in:draft,published'
        ]);

        // Handle poster upload
        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')->store('events/posters', 'public');
        }

        // Generate slug
        $validated['slug'] = Str::slug($validated['title']);

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil ditambahkan!');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'location' => 'required|string|max:255',
            'organizer' => 'required|string|max:255',
            'participants' => 'nullable|string|max:255',
            'url' => 'nullable|url',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'keywords' => 'nullable|string',
            'description' => 'required',
            'status' => 'required|in:draft,published'
        ]);

        // Handle poster upload
        if ($request->hasFile('poster')) {
            // Delete old poster
            if ($event->poster) {
                Storage::disk('public')->delete($event->poster);
            }
            $validated['poster'] = $request->file('poster')->store('events/posters', 'public');
        }

        // Update slug if title changed
        if ($validated['title'] !== $event->title) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $event->update($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil diupdate!');
    }

    public function destroy(Event $event)
    {
        // Delete poster if exists
        if ($event->poster) {
            Storage::disk('public')->delete($event->poster);
        }

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event berhasil dihapus!');
    }

    public function show(Event $event)
    {
        return view('admin.events.show', compact('event'));
    }
}