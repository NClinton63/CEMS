@extends('layouts.app')

@section('title', 'Manage Events - CEMS')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900">Manage Events</h1>
            <p class="mt-2 text-gray-600">Create and manage campus events</p>
        </div>

        @livewire('manage-events')
    </div>
</div>
@endsection
