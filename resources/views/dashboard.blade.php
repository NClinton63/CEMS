@extends('layouts.app')

@section('title', 'My Dashboard - CEMS')

@section('content')
<div class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900">My Dashboard</h1>
            <p class="mt-2 text-gray-600">Welcome back, {{ auth()->user()->name }}</p>
        </div>

        @php
            $registrations = auth()->user()->registrations()->with('event')->latest()->get();
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Total Registrations</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $registrations->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Events Attended</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $registrations->where('status', 'attended')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="card p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600 mb-1">Upcoming Events</p>
                        <p class="text-3xl font-bold text-gray-900">
                            {{ $registrations->where('status', 'registered')->filter(fn($r) => $r->event->start_time->isFuture())->count() }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-secondary-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="card p-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">My Registrations</h2>
            
            @if($registrations->count() > 0)
                <div class="space-y-4">
                    @foreach($registrations as $registration)
                        <div class="border border-gray-200 rounded-xl p-6 hover:shadow-md transition-shadow">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div class="flex-1 mb-4 md:mb-0">
                                    <div class="flex items-center mb-2">
                                        <span class="badge bg-primary-100 text-primary-700 mr-3">
                                            {{ $registration->event->category }}
                                        </span>
                                        @if($registration->status === 'attended')
                                            <span class="badge bg-green-100 text-green-800">
                                                <svg class="w-3 h-3 mr-1 inline" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                                Attended
                                            </span>
                                        @elseif($registration->status === 'cancelled')
                                            <span class="badge bg-red-100 text-red-800">Cancelled</span>
                                        @else
                                            <span class="badge bg-blue-100 text-blue-800">Registered</span>
                                        @endif
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900 mb-2">
                                        <a href="/events/{{ $registration->event->id }}" class="hover:text-primary-600 transition-colors">
                                            {{ $registration->event->title }}
                                        </a>
                                    </h3>
                                    <div class="flex flex-wrap gap-4 text-sm text-gray-600">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            {{ $registration->event->start_time->format('M d, Y') }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $registration->event->start_time->format('g:i A') }}
                                        </span>
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            {{ $registration->event->location }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    <a href="/events/{{ $registration->event->id }}" class="btn-secondary inline-flex items-center">
                                        View Event
                                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <p class="text-lg font-medium text-gray-900 mb-2">No registrations yet</p>
                    <p class="text-gray-600 mb-6">Start exploring and register for events</p>
                    <a href="/" class="btn-primary inline-flex items-center">
                        Browse Events
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
