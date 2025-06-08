<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'registration_id',
        'amount',
    ];
    public function registration()
    {
        return $this->belongsTo(\App\Models\Registration::class);
    }
}
