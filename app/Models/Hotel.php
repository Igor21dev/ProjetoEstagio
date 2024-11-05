<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    //
    //protected $table = 'hotel';

    protected $fillable = [
        'id',
        'name',
    ];

    public $timestamps = false;

    public function rooms()
    {
        return $this->hasMany(Room::class, 'hotelCode');
    }
}
