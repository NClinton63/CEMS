<?php

namespace App\Livewire;

use App\Models\AuditLog;
use App\Models\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ManageEvents extends Component
{
    use WithPagination, WithFileUploads;

    public $showModal = false;
    public $editMode = false;
    public $eventId = null;

    public $title = '';
    public $description = '';
    public $start_time = '';
    public $end_time = '';
    public $location = '';
    public $location_type = 'physical';
    public $capacity = '';
    public $category = '';
    public $featured_image = null;
    public $status = 'draft';

    protected $rules = [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'start_time' => 'required|date|after:now',
        'end_time' => 'required|date|after:start_time',
        'location' => 'required|string|max:255',
        'location_type' => 'required|in:physical,virtual',
        'capacity' => 'required|integer|min:1',
        'category' => 'nullable|string|max:100',
        'featured_image' => 'nullable|image|max:1024',
        'status' => 'required|in:draft,published',
    ];

    public function openModal()
    {
        Gate::authorize('create', Event::class);
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editMode = false;
        $this->eventId = null;
        $this->title = '';
        $this->description = '';
        $this->start_time = '';
        $this->end_time = '';
        $this->location = '';
        $this->location_type = 'physical';
        $this->capacity = '';
        $this->category = '';
        $this->featured_image = null;
        $this->status = 'draft';
        $this->resetErrorBag();
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'location' => $this->location,
            'location_type' => $this->location_type,
            'capacity' => $this->capacity,
            'category' => $this->category,
            'status' => $this->status,
            'organizer_id' => auth()->id(),
        ];

        if ($this->featured_image) {
            $data['featured_image'] = $this->featured_image->store('events', 'public');
        }

        if ($this->editMode) {
            $event = Event::findOrFail($this->eventId);
            Gate::authorize('update', $event);

            $oldValues = $event->toArray();

            if ($this->featured_image && $event->featured_image) {
                Storage::disk('public')->delete($event->featured_image);
            }

            $event->update($data);

            AuditLog::log('event.updated', $event, $oldValues, $event->toArray());

            session()->flash('success', 'Event updated successfully!');
        } else {
            $event = Event::create($data);

            AuditLog::log('event.created', $event, [], $data);

            session()->flash('success', 'Event created successfully!');
        }

        $this->closeModal();
    }

    public function edit($eventId)
    {
        $event = Event::findOrFail($eventId);
        Gate::authorize('update', $event);

        $this->editMode = true;
        $this->eventId = $event->id;
        $this->title = $event->title;
        $this->description = $event->description;
        $this->start_time = $event->start_time->format('Y-m-d\TH:i');
        $this->end_time = $event->end_time->format('Y-m-d\TH:i');
        $this->location = $event->location;
        $this->location_type = $event->location_type;
        $this->capacity = $event->capacity;
        $this->category = $event->category;
        $this->status = $event->status;

        $this->showModal = true;
    }

    public function delete($eventId)
    {
        $event = Event::findOrFail($eventId);
        Gate::authorize('delete', $event);

        if ($event->featured_image) {
            Storage::disk('public')->delete($event->featured_image);
        }

        AuditLog::log('event.deleted', $event, $event->toArray());

        $event->delete();

        session()->flash('success', 'Event deleted successfully!');
    }

    public function render()
    {
        $events = Event::where('organizer_id', auth()->id())
            ->with('activeRegistrations')
            ->orderBy('start_time', 'desc')
            ->paginate(10);

        return view('livewire.manage-events', [
            'events' => $events,
        ]);
    }
}
