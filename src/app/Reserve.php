<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    protected $fillable = [
        'room_id',
        'date_from',
        'date_to',
    ];
}
