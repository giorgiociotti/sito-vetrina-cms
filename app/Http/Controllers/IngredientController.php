<?php
namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    public function index()
    {
        $ingredients = Ingredient::all();
        return view('ingredients.index', compact('ingredients'));
    }

    public function create()
    {
        return view('ingredients.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Ingredient::create($request->only('name'));
        return redirect()->route('ingredients.index')->with('success', 'Ingrediente creato con successo!');
    }

    public function edit(Ingredient $ingredient)
    {
        return view('ingredients.edit', compact('ingredient'));
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $ingredient->update($request->only('name'));
        return redirect()->route('ingredients.index')->with('success', 'Ingrediente aggiornato con successo!');
    }

    public function destroy(Ingredient $ingredient)
    {
        $ingredient->delete();
        return redirect()->route('ingredients.index')->with('success', 'Ingrediente eliminato con successo!');
    }
}

