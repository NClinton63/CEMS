<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Your Events</h2>
            <p class="text-gray-600 mt-1">Manage and track your organized events</p>
        </div>
        <button wire:click="openModal" class="btn-primary inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Create Event
        </button>
    </div>

    @if($events->count() > 0)
        <div class="space-y-4 mt-6">
            @foreach($events as $event)
                <div class="card p-6">
                    <div class="flex flex-col lg:flex-row gap-4 lg:items-center lg:justify-between">
                        <div class="flex items-start gap-4 flex-1">
                            <div class="w-24 h-24 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                                @if($event->featured_image)
                                    <img src="{{ asset('storage/' . $event->featured_image) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-primary-100 to-primary-200 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="flex-1">
                                <div class="flex items-center mb-2 flex-wrap gap-2">
                                    <span class="badge bg-primary-100 text-primary-700">
                                        {{ $event->category ?: 'Uncategorized' }}
                                    </span>
                                    @if($event->status === 'published')
                                        <span class="badge bg-green-100 text-green-800">Published</span>
                                    @else
                                        <span class="badge bg-gray-100 text-gray-800">Draft</span>
                                    @endif
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2 line-clamp-1">{{ $event->title }}</h3>
                                <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        {{ $event->start_time->format('M d, Y') }}
                                    </span>
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        {{ $event->activeRegistrations->count() }} / {{ $event->capacity }} registered
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-2">
                            <button wire:click="edit('{{ $event->id }}')" class="px-4 py-2 text-sm font-medium text-primary-700 bg-primary-50 rounded-lg hover:bg-primary-100 transition-colors">
                                Edit
                            </button>
                            <button wire:click="delete('{{ $event->id }}')" wire:confirm="Are you sure you want to delete this event?" class="px-4 py-2 text-sm font-medium text-danger bg-red-50 rounded-lg hover:bg-red-100 transition-colors">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $events->links() }}
        </div>
    @else
        <div class="card p-12 text-center mt-6">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-lg font-medium text-gray-900 mb-2">No events yet</p>
            <p class="text-gray-600 mb-6">Create your first event to get started</p>
            <button wire:click="openModal" class="btn-primary inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Create Event
            </button>
        </div>
    @endif

    @if($showModal)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeModal">
            <div class="relative top-20 mx-auto p-5 border w-full max-w-3xl shadow-lg rounded-xl bg-white" wire:click.stop>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-900">
                        {{ $editMode ? 'Edit Event' : 'Create New Event' }}
                    </h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="save" enctype="multipart/form-data" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Event Title</label>
                            <input type="text" id="title" wire:model="title" class="input-field w-full" placeholder="Enter event title">
                            @error('title') <p class="mt-1 text-sm text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                            <textarea id="description" wire:model="description" rows="4" class="input-field w-full" placeholder="Describe your event"></textarea>
                            @error('description') <p class="mt-1 text-sm text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                            <select id="category" wire:model="category" class="input-field w-full">
                                <option value="">Select category</option>
                                <option value="Workshop">Workshop</option>
                                <option value="Seminar">Seminar</option>
                                <option value="Conference">Conference</option>
                                <option value="Social">Social</option>
                                <option value="Sports">Sports</option>
                                <option value="Cultural">Cultural</option>
                                <option value="Academic">Academic</option>
                                <option value="Career">Career</option>
                            </select>
                            @error('category') <p class="mt-1 text-sm text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">Capacity</label>
                            <input type="number" id="capacity" wire:model="capacity" class="input-field w-full" placeholder="Maximum attendees">
                            @error('capacity') <p class="mt-1 text-sm text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">Start Time</label>
                            <input type="datetime-local" id="start_time" wire:model="start_time" class="input-field w-full">
                            @error('start_time') <p class="mt-1 text-sm text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">End Time</label>
                            <input type="datetime-local" id="end_time" wire:model="end_time" class="input-field w-full">
                            @error('end_time') <p class="mt-1 text-sm text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                            <input type="text" id="location" wire:model="location" class="input-field w-full" placeholder="Event location">
                            @error('location') <p class="mt-1 text-sm text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="location_type" class="block text-sm font-medium text-gray-700 mb-2">Location Type</label>
                            <select id="location_type" wire:model="location_type" class="input-field w-full">
                                <option value="physical">In-Person</option>
                                <option value="virtual">Virtual</option>
                            </select>
                            @error('location_type') <p class="mt-1 text-sm text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-2">Featured Image</label>
                            <input type="file" id="featured_image" wire:model="featured_image" accept="image/*" class="input-field w-full">
                            @error('featured_image') <p class="mt-1 text-sm text-danger">{{ $message }}</p> @enderror
                            @if($featured_image)
                                <p class="mt-2 text-sm text-gray-600">Selected: {{ $featured_image->getClientOriginalName() }}</p>
                            @endif
                        </div>

                        <div class="md:col-span-2">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select id="status" wire:model="status" class="input-field w-full">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                            @error('status') <p class="mt-1 text-sm text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-6 border-t">
                        <button type="button" wire:click="closeModal" class="btn-secondary">
                            Cancel
                        </button>
                        <button type="submit" class="btn-primary">
                            {{ $editMode ? 'Update Event' : 'Create Event' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
    </div>
</div>
