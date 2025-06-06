<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'registered_at',
        'status',
    ];

    protected $dates = [
        'registered_at',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function event()
    {
        return $this->belongsTo(\App\Models\Event::class);
    }

    public function payment()
    {
        return $this->hasOne(\App\Models\Payment::class, 'registration_id');
    }
}
