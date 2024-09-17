<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\Category;
use App\Models\Ingredient;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    // Metodo per mostrare la singola pizza con ingredienti ordinati alfabeticamente
    public function show($id)
    {
        $pizza = Pizza::with(['ingredients' => function($query) {
            $query->orderBy('name');
        }])->findOrFail($id);

        return view('pizza', ['pizza' => $pizza]);
    }

    // Metodo di ricerca
    public function search($type, $id)
    {
        $pizzas = [];
    
        if ($type == 'ingredients') {
            // Cerca per ingredienti
            $pizzas = $this->getPizzasByIngredients([$id]);
        } elseif ($type == 'category') {
            // Cerca per categoria
            $pizzas = $this->getPizzasByCategory($id);
        } else {
            abort('404');
        }
    
        return view('home', compact('pizzas'));
    }

    // Metodo per ottenere le pizze in base agli ingredienti
    public function getPizzasByIngredients(array $ingredientIds)
    {
        // Conta quante volte le pizze appaiono con gli ingredienti forniti e controlla se hanno tutti gli ingredienti
        $pizzas = Pizza::whereHas('ingredients', function ($query) use ($ingredientIds) {
            $query->whereIn('ingredients.id', $ingredientIds);
        }, '=', count($ingredientIds))->get();

        return $pizzas;
    }

    // Metodo per ottenere le pizze in base alla categoria
    public function getPizzasByCategory($categoryId)
    {
        // Usa whereHas per filtrare le pizze appartenenti alla categoria specificata
        $pizzas = Pizza::whereHas('category', function ($query) use ($categoryId) {
            $query->where('categories.id', $categoryId);
        })->get();
    
        return $pizzas;
    }

    // Metodo per salvare una nuova pizza
    public function store(Request $request)
    {
        // Valida i dati del form
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'category' => 'required|exists:categories,id',
            'ingredients' => 'nullable|array',
            'ingredients.*' => 'exists:ingredients,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Valida il file immagine
        ]);

        // Controllo se la pizza esiste già
        $existingPizza = Pizza::where('name', $request->input('name'))->first();

        if ($existingPizza) {
            // Se esiste, reindirizza indietro con un messaggio di errore
            return redirect()->back()->with('error', 'La pizza "' . $request->input('name') . '" è già presente nel database!');
        }

        // Gestione del caricamento del file immagine (se presente)
        if ($request->hasFile('image')) {
            $fileName = now()->format('Ymd') . '_' . preg_replace('/[^A-Za-z0-9_]/', '', strtolower(str_replace(' ', '_', $request->input('name')))) . '.' . $request->file('image')->getClientOriginalExtension();

            // Sposta l'immagine nella cartella 'public/images'
            $photoPath = '' . $fileName;
            $request->file('image')->move(public_path('images'), $fileName);
        } else {
            $photoPath = null; // Se nessuna immagine è stata caricata
        }

        // Salva la pizza nel database con il percorso dell'immagine
        $pizza = Pizza::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'category_id' => $request->input('category'),
            'image' => $photoPath,  // Salva il percorso dell'immagine nel campo 'image'
        ]);

        // Associa gli ingredienti alla pizza
        if ($request->has('ingredients')) {
            $pizza->ingredients()->attach($request->input('ingredients'));
        }

        // Reindirizzamento alla home con un messaggio di successo
        return redirect()->back()->with('success', 'Pizza ' . $request->input('name') . ' aggiunta con successo!');
    }
}
