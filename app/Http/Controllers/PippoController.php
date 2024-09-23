<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PippoController extends Controller
{
    public function showPippo()
    {
        // Restituisci la vista 'pippo' con il percorso dell'immagine
        return view('pippo', ['pippoImageUrl' => asset('images/pippo.jpg')]);
    }
}
