<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Recupera i dati delle tabelle
        $users = User::all();
        $pizzas = Pizza::all();
        $ingredients = Ingredient::all();

        // Passa i dati alla vista
        return view('dashboard', compact('users', 'pizzas', 'ingredients'));
    }
}
