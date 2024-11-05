<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Reserve;
use App\Models\Daily;
use App\Models\Guest;
use App\Models\Payment;

class ReserveController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dadosValidos = $request->validate([
            'roomCode' => 'required|integer|exists:rooms,id',
            'hotelCode' => 'required|integer|exists:hotels,id',
            'checkIn' => 'required|date',
            'checkOut' => 'required|date',
            'total' => 'required|numeric',
            'guestName' => 'required|string',
            'guestLastName' => 'required|string',
            'guestPhone' => 'required|string',
            'dailyDates' => 'required|array',
            'dailyValues' => 'required|array',
            'paymentMethod' => 'required|integer',
            'paymentValue' => 'required|numeric',
        ]); 
        
        try {

            DB::beginTransaction();

            $reserve = Reserve::create([
                'roomCode' => $dadosValidos['roomCode'],
                'hotelCode' => $dadosValidos['hotelCode'],  
                'checkIn' => $dadosValidos['checkIn'],
                'checkOut' => $dadosValidos['checkOut'],
                'total' => $dadosValidos['total'],
            ]);

            foreach($dadosValidos['dailyDates'] as $key => $value) {

                $daily = Daily::create([
                    'reserve_id' => $reserve->id,
                    'date' => $value,
                    'value' => $dadosValidos['dailyValues'][$key],
                ]);
            }


            $guest = Guest::create([
                'reserve_id' => $reserve->id,
                'name' => $dadosValidos['guestName'],
                'lastName' => $dadosValidos['guestLastName'],
                'phone' => $dadosValidos['guestPhone'],
            ]);

            $payment = Payment::create([
                'reserve_id' => $reserve->id,
                'method' => $dadosValidos['paymentMethod'],
                'value' => $dadosValidos['paymentValue'],
            ]);

            DB::commit();

            return response()->json(
                [
                'message' => 'Reserva criada com sucesso', 
                'reserve' => $reserve,
                'guest' => $guest,
                'payment' => $payment,
                'daily' => $daily], 201);
            

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Reserva nao pode ser criada',
                'error' => $e->getMessage()
            ], 400);
        }
    }
}