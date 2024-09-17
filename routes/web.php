<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PizzaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index']);
Route::get('/pizza/{id}', [PizzaController::class, 'show'])->name('pizza.show');
Route::get('/search/{type}/{id}', [PizzaController::class, 'search'])->name('pizza.search');
Route::post('/pizzas/store', [PizzaController::class, 'store'])->name('pizzas.store');
