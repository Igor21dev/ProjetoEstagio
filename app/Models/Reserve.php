<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    //protected $table = 'reserve';

    protected $fillable = [
        'id',
        'hotelCode',
        'roomCode',
        'checkIn',
        'checkOut',
        'total',
        'guestCode',
        'dateDailyCode',
    ];

    public $timestamps = false;

    public function guest()
    {
        return $this->belongsTo(Guest::class, 'guestCode');
    }

    public function daily()
    {
        return $this->belongsTo(Daily::class, 'dateDailyCode');
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'paymentCode');
    }
}
