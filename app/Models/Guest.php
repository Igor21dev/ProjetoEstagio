<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    //protected $table = 'guest';

    protected $fillable = [
        'id',
        'name',
        'lastName',
        'phone',
        'reserve_id'
    ];

    public $timestamps = false;
}
