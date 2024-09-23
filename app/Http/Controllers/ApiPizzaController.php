<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use Illuminate\Http\Request;

class ApiPizzaController extends Controller
{
    // Metodo per ottenere tutte le pizze
    public function get_all()
    {
        $pizzas = Pizza::all();
        return response()->json($pizzas);
    }


    // Metodo per ottenere una singola pizza tramite ID
    public function get_pizza($id)
    {
        // Controllo se l'ID è valido (un numero intero positivo)
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['message' => 'Richiesta non valida. ID deve essere un numero intero positivo.'], 400);
        }

        // Trova la pizza tramite l'ID
        $pizza = Pizza::find($id);

        // Verifica se la pizza esiste
        if (!$pizza) {
            return response()->json(['message' => 'Pizza non trovata'], 404);
        }

        // Restituisce la pizza trovata
        return response()->json($pizza);
    }
}
