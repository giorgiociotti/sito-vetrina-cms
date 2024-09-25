<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\Category;
use App\Models\Ingredient;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Recupera i dati delle tabelle
        $users = User::all();
        $pizzas = Pizza::all();
        $ingredients = Ingredient::all();
        $categories = category::all();

        // Passa i dati alla vista
        return view('dashboard', compact('users', 'pizzas', 'ingredients', 'categories'));
    }
}
