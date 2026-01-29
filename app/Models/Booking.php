<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'schedule_id',
        'status',
        'notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isBooked(): bool
    {
        return $this->status === 'booked';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
