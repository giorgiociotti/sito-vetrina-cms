<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pizza;
use App\Models\Category;
use App\Models\Ingredient;

class HomeController extends Controller
{
    public function index()
    {

            $pizzas = Pizza::all();
        $categories = Category::orderBy('name')->get();// Recupera tutte le categorie
        $ingredients = Ingredient::orderBy('name')->get();// Recupera tutti gli ingredienti
        return view('home', compact('pizzas','ingredients','categories'));
    }
    public function create()
{
    $categories = Category::all(); // Recupera tutte le categorie
    $ingredients = Ingredient::all(); // Recupera tutti gli ingredienti
    return view('menu.create', compact('categories', 'ingredients'));
}

}
