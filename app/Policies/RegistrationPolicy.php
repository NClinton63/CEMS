<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;

class RegistrationPolicy
{
    public function register(User $user, Event $event): bool
    {
        if (!$event->isPublished()) {
            return false;
        }

        if ($event->isCancelled()) {
            return false;
        }

        if (!$event->hasCapacity()) {
            return false;
        }

        $existingRegistration = Registration::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->whereIn('status', ['registered', 'attended'])
            ->exists();

        return !$existingRegistration;
    }

    public function cancel(User $user, Registration $registration): bool
    {
        return $user->id === $registration->user_id && $registration->isRegistered();
    }

    public function view(User $user, Registration $registration): bool
    {
        return $user->id === $registration->user_id || 
               ($user->isAdministrator() && $user->id === $registration->event->organizer_id);
    }

    public function viewAny(User $user, Event $event): bool
    {
        return $user->isAdministrator() && $user->id === $event->organizer_id;
    }
}
