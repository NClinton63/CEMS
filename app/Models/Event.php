<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'location',
        'location_type',
        'capacity',
        'banner_image',
        'featured_image',
        'category',
        'organizer_id',
        'status',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'capacity' => 'integer',
    ];

    public function isPast(): bool
    {
        return $this->start_time ? $this->start_time->isPast() : false;
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function activeRegistrations()
    {
        return $this->hasMany(Registration::class)->where('status', 'registered');
    }

    public function attendedRegistrations()
    {
        return $this->hasMany(Registration::class)->where('status', 'attended');
    }

    public function registeredUsers()
    {
        return $this->belongsToMany(User::class, 'registrations')
            ->withPivot('status', 'attended_at')
            ->withTimestamps();
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isFull(): bool
    {
        return $this->activeRegistrations()->count() >= $this->capacity;
    }

    public function hasCapacity(): bool
    {
        return $this->activeRegistrations()->count() < $this->capacity;
    }

    public function availableSpots(): int
    {
        return max(0, $this->capacity - $this->activeRegistrations()->count());
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_time', '>', now());
    }

    public function scopePast($query)
    {
        return $query->where('end_time', '<', now());
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }
}
