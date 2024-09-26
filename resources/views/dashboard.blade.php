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
                                    <th>Tipo</th> <!-- Nuova colonna per il tipo di utente -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->is_admin ? 'Admin' : 'Utente' }}</td> <!-- Logica per il tipo di utente -->
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
                                    <th>Categoria</th>
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

    <!-- Sezione per il grafico -->
    <div class="chart-container">
        <h2>Analitiche Utenti e Pizze</h2>
        <canvas id="analyticsChart"></canvas>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    var ctx = document.getElementById('analyticsChart').getContext('2d');
    var analyticsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Utenti', 'Admin', 'Prezzo Medio Pizze', 'Pizze'],
            datasets: [{
                label: 'Totale',
                data: [{{ $userCount }}, {{ $adminCount }}, {{ number_format($averagePizzaPrice, 2, '.', '') }}, {{ $pizzaCount }}],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.6)',  // Blu
                    'rgba(255, 99, 132, 0.6)',   // Rosa
                    'rgba(75, 192, 192, 0.6)',   // Turchese
                    'rgba(255, 206, 86, 0.6)'    // Giallo
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',      // Blu scuro
                    'rgba(255, 99, 132, 1)',      // Rosa scuro
                    'rgba(75, 192, 192, 1)',      // Turchese scuro
                    'rgba(255, 206, 86, 1)'       // Giallo scuro
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Quantità / Prezzo (€)'
                    }
                }
            }
        }   
    });
</script>

</body>
</html>
