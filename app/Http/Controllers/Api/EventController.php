<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::with('organizer')
            ->published()
            ->upcoming()
            ->orderBy('start_time');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', "%{$search}%")
                  ->orWhere('description', 'ilike', "%{$search}%");
            });
        }

        if ($request->has('category')) {
            $query->byCategory($request->input('category'));
        }

        if ($request->has('organizer_id')) {
            $query->where('organizer_id', $request->input('organizer_id'));
        }

        $events = $query->paginate(15);

        return response()->json($events);
    }

    public function show(Event $event)
    {
        Gate::authorize('view', $event);

        $event->load('organizer', 'activeRegistrations');

        return response()->json([
            'event' => $event,
            'available_spots' => $event->availableSpots(),
            'is_full' => $event->isFull(),
        ]);
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Event::class);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'start_time' => ['required', 'date', 'after:now'],
            'end_time' => ['required', 'date', 'after:start_time'],
            'location' => ['required', 'string', 'max:255'],
            'location_type' => ['sometimes', 'in:physical,virtual'],
            'capacity' => ['required', 'integer', 'min:1'],
            'category' => ['nullable', 'string', 'max:100'],
            'banner_image' => ['nullable', 'image', 'max:2048'],
            'status' => ['sometimes', 'in:draft,published'],
        ]);

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('banners', 'public');
        }

        $validated['organizer_id'] = $request->user()->id;

        $event = Event::create($validated);

        AuditLog::log('event.created', $event, [], $validated);

        return response()->json([
            'message' => 'Event created successfully',
            'event' => $event,
        ], 201);
    }

    public function update(Request $request, Event $event)
    {
        Gate::authorize('update', $event);

        $oldValues = $event->toArray();

        $validated = $request->validate([
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'string'],
            'start_time' => ['sometimes', 'date', 'after:now'],
            'end_time' => ['sometimes', 'date', 'after:start_time'],
            'location' => ['sometimes', 'string', 'max:255'],
            'location_type' => ['sometimes', 'in:physical,virtual'],
            'capacity' => ['sometimes', 'integer', 'min:1'],
            'category' => ['nullable', 'string', 'max:100'],
            'banner_image' => ['nullable', 'image', 'max:2048'],
            'status' => ['sometimes', 'in:draft,published,cancelled'],
        ]);

        if ($request->hasFile('banner_image')) {
            if ($event->banner_image) {
                Storage::disk('public')->delete($event->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('banners', 'public');
        }

        $event->update($validated);

        AuditLog::log('event.updated', $event, $oldValues, $event->toArray());

        return response()->json([
            'message' => 'Event updated successfully',
            'event' => $event->fresh(),
        ]);
    }

    public function destroy(Event $event)
    {
        Gate::authorize('delete', $event);

        if ($event->banner_image) {
            Storage::disk('public')->delete($event->banner_image);
        }

        AuditLog::log('event.deleted', $event, $event->toArray());

        $event->delete();

        return response()->json([
            'message' => 'Event deleted successfully',
        ]);
    }

    public function myEvents(Request $request)
    {
        $events = Event::where('organizer_id', $request->user()->id)
            ->with('activeRegistrations')
            ->orderBy('start_time', 'desc')
            ->paginate(15);

        return response()->json($events);
    }
}
