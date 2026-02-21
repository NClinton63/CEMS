@extends('layouts.app')

@section('title', $event->title . ' - CEMS')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    @livewire('event-details', ['eventId' => $event->id])
</div>
@endsection
