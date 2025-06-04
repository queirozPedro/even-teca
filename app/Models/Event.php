<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'location',
        'organizer_id',
        'capacity',
        'price',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'event_user');
    }

    public function organizer()
    {
        return $this->belongsTo(\App\Models\User::class, 'organizer_id');
    }
}
