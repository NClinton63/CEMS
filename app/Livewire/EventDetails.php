<?php

namespace App\Livewire;

use App\Models\AuditLog;
use App\Models\Event;
use App\Models\Registration;
use App\Notifications\RegistrationConfirmed;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class EventDetails extends Component
{
    public Event $event;
    public $userRegistration = null;

    public function mount(Event $event)
    {
        Gate::authorize('view', $event);
        $this->event = $event;
        $this->loadUserRegistration();
    }

    public function loadUserRegistration()
    {
        if (auth()->check()) {
            $this->userRegistration = Registration::where('user_id', auth()->id())
                ->where('event_id', $this->event->id)
                ->whereIn('status', ['registered', 'attended'])
                ->first();
        }
    }

    public function register()
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        try {
            Gate::authorize('register', [Registration::class, $this->event]);

            $registration = Registration::create([
                'user_id' => auth()->id(),
                'event_id' => $this->event->id,
                'status' => 'registered',
            ]);

            AuditLog::log('registration.created', $registration);

            auth()->user()->notify(new RegistrationConfirmed($this->event));

            $this->loadUserRegistration();
            $this->event->refresh();

            session()->flash('success', 'Successfully registered for the event!');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function cancelRegistration()
    {
        if (!$this->userRegistration) {
            return;
        }

        Gate::authorize('cancel', $this->userRegistration);

        $this->userRegistration->cancel();

        AuditLog::log('registration.cancelled', $this->userRegistration);

        $this->userRegistration = null;
        $this->event->refresh();

        session()->flash('success', 'Registration cancelled successfully.');
    }

    public function render()
    {
        return view('livewire.event-details');
    }
}
