<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //protected $table = 'payment';
    
    protected $fillable = [
        'id', 
        'method', 
        'value',
        'reserve_id'
    ];

    public $timestamps = false;
}
