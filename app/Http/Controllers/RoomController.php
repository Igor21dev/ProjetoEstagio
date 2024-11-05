<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $room = Room::all();
        if($room->isEmpty()) {
            return response()->json(['message' => 'Quartos não encontrados'], 404);
        }else{
            return response()->json([
                'message' =>'Quartos encontrados', 
                'room' => $room], 200);            
        }

    }

 

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dadosValidos = $request->validate([
            'name' => 'required',
            'hotelCode' => 'required|integer|exists:hotels,id',
        ]);

        $room = Room::create([
            'name' => $dadosValidos['name'],
            'hotelCode' => $dadosValidos['hotelCode'],
        ]);
        
        return response()->json(
            [
            'message' => 'Quarto criado com sucesso', 
            'room' => $room], 201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $room = Room::find($id);
        return response()->json(
            [
                'message' => 'Quarto encontrado', 
                'room' => $room], 200);            

    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $dadosValidos = $request->validate([
            'name' => 'required',
            'hotelCode' => 'required|integer|exists:hotels,id',
        ]);
        $room = Room::find($id);
        $room->update($dadosValidos);
        return response()->json(
            ['message' => 'Quarto atualizado com sucesso',
            'room' => $room], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $room = Room::find($id);
            $room->delete();
            return response()->json(
                ['message' => 'Quarto deletado com sucesso',
                'room' => $room], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Quarto não pode ser deletado pois esta sendo utilizado numa reserva'
            ], 400);
        }
    }
}
