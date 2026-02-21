<?php

use App\Livewire\EventDetails;
use App\Livewire\EventList;
use App\Livewire\ManageEvents;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/events');
});

Route::get('/events', EventList::class)->name('events.index');
Route::get('/events/{event}', EventDetails::class)->name('events.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/events', ManageEvents::class)->name('admin.events');
});

require __DIR__.'/auth.php';
