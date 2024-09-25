<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { margin-top: 20px; }
        table {
            border: 2px solid black; /* Bordo solido nero per la tabella */
            width: 100%; /* Occupare l'intera larghezza */
            margin-bottom: 20px; /* Spaziatura tra le tabelle */
        }
        th, td {
            border: 1px solid black; /* Bordo delle celle */
            text-align: center; /* Centrare il testo nelle celle */
        }
        th {
            background-color: #f8f9fa; /* Colore di sfondo per l'intestazione */
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <!-- Finestra 1: Dati degli Utenti -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Utenti</h3>
                </div>
                <div class="card-body">
                    @if ($users->isEmpty())
                        <p>Nessun utente disponibile</p>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        <!-- Finestra 2: Dati delle Pizze -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title">Pizze</h3>
                </div>
                <div class="card-body">
                    @if ($pizzas->isEmpty())
                        <p>Nessuna pizza disponibile</p>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Prezzo</th>
                                    <th>Ingredienti</th>
                                    <th>Categoria</th> <!-- Nuova colonna per la categoria -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pizzas as $pizza)
                                    <tr>
                                        <td>{{ $pizza->name }}</td>
                                        <td>€{{ number_format($pizza->price, 2, ',', '.') }}</td>
                                        <td>
                                            @foreach ($pizza->ingredients as $ingredient)
                                                {{ $ingredient->name }}@if(!$loop->last), @endif
                                            @endforeach
                                        </td>
                                        <td>{{ $pizza->category->name }}</td> <!-- Mostra il nome della categoria -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        <!-- Finestra 3: Dati degli Ingredienti -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title">Ingredienti</h3>
                </div>
                <div class="card-body">
                    @if ($ingredients->isEmpty())
                        <p>Nessun ingrediente disponibile</p>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ingredients as $ingredient)
                                    <tr>
                                        <td>{{ $ingredient->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
