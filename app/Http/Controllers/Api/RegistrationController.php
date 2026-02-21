<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Event;
use App\Models\Registration;
use App\Notifications\RegistrationConfirmed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RegistrationController extends Controller
{
    public function register(Request $request, Event $event)
    {
        Gate::authorize('register', [Registration::class, $event]);

        $registration = Registration::create([
            'user_id' => $request->user()->id,
            'event_id' => $event->id,
            'status' => 'registered',
        ]);

        AuditLog::log('registration.created', $registration);

        $request->user()->notify(new RegistrationConfirmed($event));

        return response()->json([
            'message' => 'Successfully registered for event',
            'registration' => $registration->load('event'),
        ], 201);
    }

    public function cancel(Request $request, Event $event)
    {
        $registration = Registration::where('user_id', $request->user()->id)
            ->where('event_id', $event->id)
            ->where('status', 'registered')
            ->firstOrFail();

        Gate::authorize('cancel', $registration);

        $registration->cancel();

        AuditLog::log('registration.cancelled', $registration);

        return response()->json([
            'message' => 'Registration cancelled successfully',
        ]);
    }

    public function myRegistrations(Request $request)
    {
        $registrations = Registration::where('user_id', $request->user()->id)
            ->with('event.organizer')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json($registrations);
    }

    public function eventRegistrations(Request $request, Event $event)
    {
        Gate::authorize('viewAny', [Registration::class, $event]);

        $registrations = Registration::where('event_id', $event->id)
            ->with('user')
            ->orderBy('created_at')
            ->paginate(50);

        return response()->json($registrations);
    }

    public function markAttendance(Request $request, Event $event)
    {
        Gate::authorize('markAttendance', $event);

        $validated = $request->validate([
            'user_id' => ['required', 'uuid', 'exists:users,id'],
        ]);

        $registration = Registration::where('user_id', $validated['user_id'])
            ->where('event_id', $event->id)
            ->where('status', 'registered')
            ->firstOrFail();

        $registration->markAsAttended();

        AuditLog::log('registration.attended', $registration);

        return response()->json([
            'message' => 'Attendance marked successfully',
            'registration' => $registration->fresh(),
        ]);
    }
}
