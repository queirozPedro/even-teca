<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
        'category',
    ];
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'event_user')->withPivot('status');
    }

    public function up()
    {
        Schema::table('event_user', function (Blueprint $table) {
            $table->string('status')->default('confirmed');
        });
    }
}
