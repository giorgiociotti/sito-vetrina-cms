<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pizza;
use App\Models\Category;
use App\Models\Ingredient;

class DashboardController extends Controller
{
    public function index()
    {
        // Recupera tutti gli utenti e le pizze
        $users = User::all();
        $pizzas = Pizza::with('ingredients', 'category')->get();
        $ingredients = Ingredient::all();

        // Conta il numero totale di utenti e pizze
        $userCount = $users->count();
        $pizzaCount = $pizzas->count();

        // Conta gli utenti che sono admin (assumendo che il campo 'is_admin' indichi se l'utente è un admin)
        $adminCount = $users->where('is_admin', true)->count();

        // Calcola il prezzo medio delle pizze
        $averagePizzaPrice = $pizzas->avg('price');

        return view('dashboard', compact('users', 'pizzas', 'ingredients', 'userCount', 'pizzaCount', 'adminCount', 'averagePizzaPrice'));
    }
}
