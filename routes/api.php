<?php

use App\Http\Controllers\ReserveController;
use App\Http\Controllers\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('rooms', RoomController::class);

Route::post('reserves', [ReserveController::class, 'store']);

//Route::get('/rooms', [RoomController::class, 'index']);
//Route::get('/rooms/{id}', [RoomController::class, 'show']);
//Route::post('/rooms', [RoomController::class, 'store']);
//Route::put('/rooms/{id}', action([RoomController::class, 'update']));
//Route::delete('/rooms/{id}', [RoomController::class, 'destroy']);