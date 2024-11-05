<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Daily extends Model
{
    //protected $table = 'daily';

    protected $fillable = [
        'id',
        'date',
        'value',
        'reserve_id'
    ];

    public $timestamps = false;
}
