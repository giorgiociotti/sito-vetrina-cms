<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\ApiPizzaController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PippoController;   
//routes for the pizzeria application

Route::get("/register", [RegisterController::class, 'create'])->name('register');
Route::post("/register", [RegisterController::class, 'store'])->name('register.store');

Route::get('login', [LoginController::class, 'create'])->name('login');
Route::post('login', [LoginController::class, 'store'])->name('login.store');

Route::post('logout', LogoutController::class)->name('logout');
Route::post('logout', LogoutController::class)->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
    Route::resource('tasks', TaskController::class);
    Route::post('logout', LogoutController::class)->name('logout');
});


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/pizza/{id}', [PizzaController::class, 'show'])->name('pizza.show');
Route::get('/search/{type}/{id}', [PizzaController::class, 'search'])->name('pizza.search');
Route::post('/pizzas/store', [PizzaController::class, 'store'])->name('pizzas.store');
Route::delete('/pizzas/{id}', [PizzaController::class, 'destroy'])->name('pizzas.destroy');

// Rotte per la modifica e l'aggiornamento della pizza
Route::get('/pizza/{id}/edit', [PizzaController::class, 'edit'])->name('pizza.edit');
Route::put('/pizza/{id}', [PizzaController::class, 'update'])->name('pizza.update');
