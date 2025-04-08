<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'created_by',
        'date_start',
        'time_start',
        'date_end',
        'time_end',
    ];

    public function organizer()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
}
