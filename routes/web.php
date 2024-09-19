<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\ApiPizzaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PippoController;   
//routes for the pizzeria application
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/pizza/{id}', [PizzaController::class, 'show'])->name('pizza.show');
Route::get('/search/{type}/{id}', [PizzaController::class, 'search'])->name('pizza.search');
Route::post('/pizzas/store', [PizzaController::class, 'store'])->name('pizzas.store');
Route::delete('/pizzas/{id}', [PizzaController::class, 'destroy'])->name('pizzas.destroy');
