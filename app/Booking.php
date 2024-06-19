<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'client_id',
        'start',
        'end',
        'notes',
    ];

    protected $dates = [
        'start',
        'end',
    ];

    protected $appends = [
        'formatted_time_duration',
    ];

    public function getFormattedTimeDurationAttribute(): string
    {
        return $this->start->format('l d F Y H:i') . ' - ' . $this->end->format('H:i');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('end', '>=', now());
    }

    public function scopePast($query)
    {
        return $query->where('start', '<', now());
    }
}
