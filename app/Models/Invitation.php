<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'attendee_email',
        'rsvp_status',
        'rsvp_link',
        'seat_type',
        'seat_number',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
