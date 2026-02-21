<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Event $event): bool
    {
        if ($event->isPublished()) {
            return true;
        }

        return $user && ($user->isAdministrator() || $user->id === $event->organizer_id);
    }

    public function create(User $user): bool
    {
        return $user->isAdministrator();
    }

    public function update(User $user, Event $event): bool
    {
        return $user->isAdministrator() && $user->id === $event->organizer_id;
    }

    public function delete(User $user, Event $event): bool
    {
        return $user->isAdministrator() && $user->id === $event->organizer_id;
    }

    public function publish(User $user, Event $event): bool
    {
        return $user->isAdministrator() && $user->id === $event->organizer_id;
    }

    public function cancel(User $user, Event $event): bool
    {
        return $user->isAdministrator() && $user->id === $event->organizer_id;
    }

    public function manageRegistrations(User $user, Event $event): bool
    {
        return $user->isAdministrator() && $user->id === $event->organizer_id;
    }

    public function markAttendance(User $user, Event $event): bool
    {
        return $user->isAdministrator() && $user->id === $event->organizer_id;
    }
}
