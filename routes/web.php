<?php

use App\Http\Controllers\{
    HomeController,
    PizzaController,
    ApiPizzaController,
    Auth\RegisterController,
    Auth\LogoutController,
    Auth\LoginController,
    PippoController,
    DashboardController,
    UserController,
    IngredientController,
    TaskController
};
use Illuminate\Support\Facades\Route;

// Rotte per autenticazione (Registrazione, Login, Logout)
Route::get("/register", [RegisterController::class, 'create'])->name('register');
Route::post("/register", [RegisterController::class, 'store'])->name('register.store');

Route::get('login', [LoginController::class, 'create'])->name('login');
Route::post('login', [LoginController::class, 'store'])->name('login.store');

Route::post('logout', [LogoutController::class, 'logout'])->name('logout')->middleware('auth');

// Rotte per la pizzeria
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/pizza/{id}', [PizzaController::class, 'show'])->name('pizza.show');
Route::get('/search/{type}/{id}', [PizzaController::class, 'search'])->name('pizza.search');
Route::post('/pizzas/store', [PizzaController::class, 'store'])->name('pizzas.store');
Route::delete('/pizzas/{id}', [PizzaController::class, 'destroy'])->name('pizzas.destroy');
Route::get('/pizza/edit/{id}', [PizzaController::class, 'edit'])->name('pizza.edit');
Route::put('/pizza/{id}', [PizzaController::class, 'update'])->name('pizza.update');

// Easter egg
Route::get('/pippo', [PippoController::class, 'showPippo']);

// Rotte per la dashboard e gestione utenti (accessibili solo agli admin)
Route::middleware(['isAdmin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Rotte per la gestione utenti
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
    });
});

// Rotte per la gestione degli ingredienti (accessibili solo agli admin)
Route::middleware(['isAdmin'])->prefix('ingredients')->name('ingredients.')->group(function () {
    Route::get('/', [IngredientController::class, 'index'])->name('index');
    Route::get('/create', [IngredientController::class, 'create'])->name('create');
    Route::post('/', [IngredientController::class, 'store'])->name('store');
    Route::get('/edit/{ingredient}', [IngredientController::class, 'edit'])->name('edit');
    Route::put('/{ingredient}', [IngredientController::class, 'update'])->name('update');
    Route::delete('/{ingredient}', [IngredientController::class, 'destroy'])->name('destroy');
});

// Rotte per task management (protette da autenticazione)
Route::group(['middleware' => 'auth'], function () {
    Route::resource('tasks', TaskController::class);
});
