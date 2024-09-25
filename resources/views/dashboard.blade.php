<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container { margin-top: 20px; }
        .panel { margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="container">
    <div class="row">
        <!-- Finestra 1: Dati degli Utenti -->
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Users</h3>
                </div>
                <div class="panel-body">
                    @if ($users->isEmpty())
                        <p>No users available</p>
                    @else
                        <ul class="list-group">
                            @foreach ($users as $user)
                                <li class="list-group-item">
                                    {{ $user->name }} - {{ $user->email }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <!-- Finestra 2: Dati delle Pizze -->
        <div class="col-md-4">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">Pizzas</h3>
                </div>
                <div class="panel-body">
                    @if ($pizzas->isEmpty())
                        <p>No pizzas available</p>
                    @else
                        <ul class="list-group">
                            @foreach ($pizzas as $pizza)
                                <li class="list-group-item">
                                    {{ $pizza->name }} - €{{ $pizza->price }}
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>

        <!-- Finestra 3: Dati degli Ingredienti -->
        <div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Ingredients</h3>
                </div>
                <div class="panel-body">
                    @if ($ingredients->isEmpty())
                        <p>No ingredients available</p>
                    @else
                        <ul class="list-group">
                            @foreach ($ingredients as $ingredient)
                                <li class="list-group-item">
                                    {{ $ingredient->name }} - {{ $ingredient->quantity }}g
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
