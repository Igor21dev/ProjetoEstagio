<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //protected $table = 'room';

    protected $fillable = [
        'id',
        'name',
        'hotelCode'
    ];

    public $timestamps = false;

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotelCode');
    }
}
