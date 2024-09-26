<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pizzeria Ecommerce</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            padding-top: 56px;
        }
        .pizza-img {
            max-width: 100%;
            height: auto;
        }
        .header-bg {
            background: url('/images/pizza-banner.jpg') no-repeat center center;
            background-size: cover;
            height: 60vh;
        }
        .header-content {
            color: white;
            text-align: center;
            padding: 100px 0;
        }
        footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Pizzeria</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#menu">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contatti</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <form method="POST" action={{ route('logout') }}>
    @csrf
    <button type="submit">Logout</button>
</form>
    <!-- Header -->
    <header class="header-bg">
        <div class="header-content">
            <h1>Benvenuto alla Pizzeria Online</h1>
            <p>Ordina la tua pizza preferita comodamente da casa</p>
            <a href="#menu" class="btn btn-primary btn-lg">Vedi il nostro menu</a>
        </div>
    </header>
    {{Auth::user()}}

    <!-- Menu Section -->
    <section id="menu" class="py-5">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="container">
            <h2 class="text-center">Il nostro Menu</h2>
            <!-- Elenco delle pizze -->
            <div class="row">
                @foreach ($pizzas as $pizza)
                    <div class="col-md-3">
                        <div class="card mb-4">
                            <img src="{{ asset('images/' . $pizza->image) }}" class="card-img-top pizza-img" alt="{{ $pizza->name }}">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $pizza->name }}</h5>
                                <h5 class="card-title">€{{ $pizza->price }}</h5>
                                <p class="card-text">{{ $pizza->description }}</p>
                                <a href="{{ route('pizza.show', ['id' => $pizza->id]) }}" class="btn btn-primary">Dettagli</a>
                                <a href="#" class="btn btn-primary">Aggiungi al carrello</a>
                                
                 <!-- Modulo di cancellazione, visibile solo agli amministratori -->
                 @if(Auth::check() && Auth::user()->isAdmin())
                                <form action="{{ route('pizzas.destroy', ['id' => $pizza->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Sei sicuro di voler eliminare questa pizza?')">Elimina</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

          
    </div>
</div>