<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'postcode',
        'user_id',
    ];

    protected $appends = [
        'url',
    ];

    public function getBookingsCountAttribute(): int
    {
        return $this->bookings->count();
    }

    public function getUrlAttribute(): string
    {
        return "/clients/" . $this->id;
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function journals(): HasMany
    {
        return $this->hasMany(Journal::class);
    }
}
