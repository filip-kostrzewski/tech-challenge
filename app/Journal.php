<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Journal extends Model
{
    protected $fillable = [
        'content',
        'date',
        'client_id'
    ];

    protected $casts = [
        'date' => 'date:l d F Y',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }
}
