<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pizza;
use App\Models\Category;
use App\Models\Ingredient;  

class IngredientController extends Controller
{
    public function index()
    {
        // Recupera tutti gli ingredienti e ordina per nome
        $ingredients = Ingredient::orderBy('name')->get();
    
        return view('admin.index_Ingredient', compact('ingredients'));
    }

    public function create()
    {
        return view('admin.create_Ingredient');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ingredients,name',
        ], [
            'name.required' => 'Il nome dell\'ingrediente è obbligatorio.',
            'name.unique' => 'Questo ingrediente è già stato aggiunto.',
        ]);

        Ingredient::create($request->only('name'));
        return redirect()->route('ingredients.index')->with('success', 'Ingrediente creato con successo!');
    }

    public function edit(Ingredient $ingredient)
    {
        return view('admin.edit_Ingredient', compact('ingredient'));
    }

    public function update(Request $request, Ingredient $ingredient)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:ingredients,name,' . $ingredient->id,
        ], [
            'name.required' => 'Il nome dell\'ingrediente è obbligatorio.',
            'name.unique' => 'Questo ingrediente è già stato aggiunto.',
        ]);

        $ingredient->update($request->only('name'));
        return redirect()->route('ingredients.index')->with('success', 'Ingrediente aggiornato con successo!');
    }

    public function destroy(Ingredient $ingredient)
    {
        // Facoltativo: Gestire il caso in cui ci siano pizze associate all'ingrediente
        if ($ingredient->pizzas()->count() > 0) {
            return redirect()->route('ingredients.index')->with('error', 'Impossibile eliminare l\'ingrediente poiché è associato a una o più pizze.');
        }

        $ingredient->delete();
        return redirect()->route('ingredients.index')->with('success', 'Ingrediente eliminato con successo!');
    }
}
