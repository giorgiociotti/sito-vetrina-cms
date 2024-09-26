<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .container { margin-top: 20px; }
        table {
            border: 2px solid black;
            width: 100%;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid black;
            text-align: center;
        }
        th {
            background-color: #f8f9fa;
        }
        .chart-container {
            margin-top: 40px;
        }
        .card-title {
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Dashboard</h2>

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="dashboardTabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#users">Utenti</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#pizzas">Pizze</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#ingredients">Ingredienti</a>
        </li>
    </ul>

    <div class="tab-content">
        <!-- Tab Utenti -->
        <div class="tab-pane fade show active" id="users">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title">Gestione Utenti</h3>
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
                                    <th>Tipo</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->is_admin ? 'Admin' : 'Utente' }}</td>
                                        <td>
                                            <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">Modifica</a>
                                            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Sei sicuro di voler eliminare questo utente?');">Elimina</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    <a href="{{ route('users.create') }}" class="btn btn-success">Aggiungi Utente</a>
                </div>
            </div>
        </div>

        <!-- Tab Pizze -->
        <div class="tab-pane fade" id="pizzas">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h3 class="card-title">Gestione Pizze</h3>
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
                                    <th>Categoria</th>
                                    <th>Azioni</th>
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
                                        <td>{{ $pizza->category->name }}</td>
                                        <td>
                                            <a href="{{ route('pizza.edit', $pizza) }}" class="btn btn-warning btn-sm">Modifica</a>
                                            <form action="{{ route('pizzas.destroy', $pizza) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Sei sicuro di voler eliminare questa pizza?');">Elimina</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    <a href="{{ route('pizza.edit', $pizza) }}" class="btn btn-success">Aggiungi Pizza</a>
                </div>
            </div>
        </div>

        <!-- Tab Ingredienti -->
        <div class="tab-pane fade" id="ingredients">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h3 class="card-title">Gestione Ingredienti</h3>
                </div>
                <div class="card-body">
                    @if ($ingredients->isEmpty())
                        <p>Nessun ingrediente disponibile</p>
                    @else
                        <table>
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ingredients as $ingredient)
                                    <tr>
                                        <td>{{ $ingredient->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.edit_Ingredient', $ingredient) }}" class="btn btn-warning btn-sm">Modifica</a>
                                            <form action="{{ route('ingredients.destroy', $ingredient) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Sei sicuro di voler eliminare questo ingrediente?');">Elimina</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                    <a href="{{ route('admin.create_Ingredient') }}" class="btn btn-success">Aggiungi Ingrediente</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
