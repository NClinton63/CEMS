<?php

namespace App\Livewire;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;

class EventList extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $sortBy = 'start_time';

    protected $queryString = ['search', 'category'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Event::with('organizer')
            ->published()
            ->upcoming()
            ->orderBy($this->sortBy);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'ilike', "%{$this->search}%")
                  ->orWhere('description', 'ilike', "%{$this->search}%");
            });
        }

        if ($this->category) {
            $query->byCategory($this->category);
        }

        $events = $query->paginate(12);
        $categories = Event::published()->distinct()->pluck('category')->filter();

        return view('livewire.event-list', [
            'events' => $events,
            'categories' => $categories,
        ]);
    }
}
