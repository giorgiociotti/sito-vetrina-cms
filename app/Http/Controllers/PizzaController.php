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
        $pizzas = Pizza::whereHas('ingredients', function ($query) use ($ingredientIds) {
            $query->whereIn('ingredients.id', $ingredientIds);
        }, '=', count($ingredientIds))->get();

        return $pizzas;
    }

    // Metodo per ottenere le pizze in base alla categoria
    public function getPizzasByCategory($categoryId)
    {
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
            'price' => 'required'
        ]);

        // Controlla se una pizza con lo stesso nome esiste già nel database
        $existingPizza = Pizza::where('name', $request->input('name'))->first();
        if ($existingPizza) {
            return redirect()->back()->with('error', 'La pizza "' . $request->input('name') . '" esiste già.');
        }

        // Gestione del caricamento del file immagine (se presente)
        if ($request->hasFile('image')) {
            $fileName = now()->format('Ymd') . '_' . preg_replace('/[^A-Za-z0-9_]/', '', strtolower(str_replace(' ', '_', $request->input('name')))) . '.' . $request->file('image')->getClientOriginalExtension();

            // Sposta l'immagine nella cartella 'public/images'
            $photoPath =  $fileName;
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
            'price'=> $request
        ]);

        // Associa gli ingredienti alla pizza
        if ($request->has('ingredients')) {
            $pizza->ingredients()->attach($request->input('ingredients'));
        }

        // Reindirizzamento alla home con un messaggio di successo
        return redirect()->back()->with('success', 'Pizza "' . $request->input('name') . '" aggiunta con successo!');
    }

    public function destroy($id)
{
    // Trova la pizza per ID
    $pizza = Pizza::find($id);

    // Verifica se la pizza esiste
    if (!$pizza) {
        return redirect()->route('home')->with('error', 'Pizza non trovata.');
    }

    // Elimina la pizza
    $pizza->delete();

    // Reindirizza con un messaggio di successo
    return redirect()->route('home')->with('success', 'Pizza eliminata con successo.');
}
// Metodo per mostrare il form di modifica della pizza
public function edit($id)
{
    // Trova la pizza da modificare per ID
    $pizza = Pizza::findOrFail($id);
    
    // Ottieni tutte le categorie e ingredienti per popolare il form di modifica
    $categories = Category::all();
    $ingredients = Ingredient::all();
    
    // Ritorna una vista con i dati della pizza, categorie e ingredienti
    return view('admin.edit_pizza', compact('pizza', 'categories', 'ingredients'));
}

// Metodo per aggiornare una pizza esistente
public function update(Request $request, $id)
{
    // Valida i dati del form
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:1000',
        'category' => 'required|exists:categories,id',
        'ingredients' => 'nullable|array',
        'ingredients.*' => 'exists:ingredients,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // L'immagine è opzionale
        'price' => 'required|numeric|min:0',
    ]);

    // Trova la pizza per ID
    $pizza = Pizza::findOrFail($id);

    // Verifica se una pizza con lo stesso nome già esiste (escludendo la pizza attuale)
    $existingPizza = Pizza::where('name', $request->input('name'))->where('id', '!=', $pizza->id)->first();
    if ($existingPizza) {
        return redirect()->back()->with('error', 'Una pizza con il nome "' . $request->input('name') . '" esiste già.');
    }

    // Gestione del caricamento dell'immagine (se presente)
    if ($request->hasFile('image')) {
        $fileName = now()->format('Ymd') . '_' . preg_replace('/[^A-Za-z0-9_]/', '', strtolower(str_replace(' ', '_', $request->input('name')))) . '.' . $request->file('image')->getClientOriginalExtension();

        // Sposta l'immagine nella cartella 'public/images'
        $photoPath =  $fileName;
        $request->file('image')->move(public_path('images'), $fileName);
    } else {
        $photoPath = $pizza->image; // Mantieni l'immagine precedente se non ne viene caricata una nuova
    }

    // Aggiorna i dati della pizza
    $pizza->update([
        'name' => $request->input('name'),
        'description' => $request->input('description'),
        'category_id' => $request->input('category'),
        'image' => $photoPath,
    ]);

    // Aggiorna gli ingredienti associati alla pizza
    if ($request->has('ingredients')) {
        $pizza->ingredients()->sync($request->input('ingredients'));
    } else {
        // Se nessun ingrediente viene selezionato, rimuovi tutti gli ingredienti associati
        $pizza->ingredients()->detach();
    }

    // Reindirizza con un messaggio di successo
    return redirect()->route('home')->with('success', 'Pizza "' . $pizza->name . '" aggiornata con successo!');
}
 // Metodo per visualizzare il modulo di creazione di una nuova pizza
 public function add()
 {
     $categories = Category::all(); // Assicurati di avere il modello Category
     $ingredients = Ingredient::all(); // Assicurati di avere il modello Ingredient
 
     return view('admin.create_pizza', compact('categories', 'ingredients'));
 }

          
}
