<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\ApiPizzaController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PippoController;   
use App\Http\Controllers\DashboardController;   
use App\Http\Controllers\UserController;   
use App\Http\Controllers\IngredientController;

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
Route::get('/pizza/edit/{id}', [PizzaController::class, 'edit'])->name('pizza.edit');
Route::put('/pizza/{id}', [PizzaController::class, 'update'])->name('pizza.update');

//easter egg
Route::get('/pippo', [PippoController::class, 'showPippo']);

//dashboard
Route::middleware(['isAdmin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    
    Route::get('/users', function () {
        return 'Users';
    });
});
// Rotta per visualizzare tutti gli utenti
Route::get('/users', [UserController::class, 'index'])->name('users.index');

// Rotta per mostrare il form di creazione di un nuovo utente
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

// Rotta per memorizzare un nuovo utente nel database
Route::post('/users', [UserController::class, 'store'])->name('users.store');

// Rotta per visualizzare un singolo utente
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

// Rotta per mostrare il form di modifica di un utente
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

// Rotta per aggiornare un utente esistente
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

// Rotta per cancellare un utente
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

// Rotte per la gestione degli ingredienti
Route::prefix('ingredients')->name('ingredients.')->group(function () {
    Route::get('/', [IngredientController::class, 'index'])->name('index');
    Route::get('/create', [IngredientController::class, 'create'])->name('create');
    Route::post('/', [IngredientController::class, 'store'])->name('store');
    Route::get('/{ingredient}/edit', [IngredientController::class, 'edit'])->name('edit');
    Route::put('/{ingredient}', [IngredientController::class, 'update'])->name('update');
    Route::delete('/{ingredient}', [IngredientController::class, 'destroy'])->name('destroy');
});

// Rotte per la gestione degli ingredienti
Route::middleware(['isAdmin'])->group(function () {
    Route::resource('ingredients', IngredientController::class);
});
