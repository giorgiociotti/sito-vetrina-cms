<?php

use Illuminate\Http\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\ApiPizzaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PippoController;   

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//API Routes
//Route::get('/all', [ApiPizzaController::class, 'get_all'])->name('api.pizzas.all');
Route::get('/pizza/{id}', [ApiPizzaController::class, 'get_pizza'])->name('api.pizzas.single');
//easter egg
Route::get('/pippo', [PippoController::class, 'showPippo']);

