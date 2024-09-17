<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pizza->name }} - Pizzeria Ecommerce</title>
    
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
    <!-- Navbar -->

    <!-- Pizza Detail -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <!-- Immagine della pizza -->
                <img src="{{ asset('images/' . $pizza->image) }}" alt="{{ $pizza->name }}" class="pizza-img">
            </div>
            <div class="col-md-6">
                <h1>{{ $pizza->name }}</h1>
                <h5>Descrizione:</h5>
                <p>{{ $pizza->description }}</p>
                <h5>Categoria:</h5>
<p>
    <a href="{{ route('pizza.search', ['type' => 'category', 'id' => $pizza->category->id]) }}" class="btn btn-primary">
        {{ $pizza->category->name }}
    </a>
</p>

                <h5>Prezzo:</h5>
                <p>€{{ number_format($pizza->price, 2) }}</p>

                <!-- Lista degli ingredienti -->
                <h5>Ingredienti:</h5>
                <ul>
                    @foreach ($pizza->ingredients->sortBy('name') as $ingredient)
                        <li>
                         <a href="{{ route('pizza.search', ['type' => 'ingredients', 'id'=> $ingredient->id]) }}" class="btn btn-primary"> {{ $ingredient->name }}</a>
                       </li>
                        
                    @endforeach
                </ul>
                {{$pizza->category()->get()}}
            </div>
        </div>
    </div>

    <!-- Contact Section --> 
    <section id="contact" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center">Contattaci</h2>
            <div class="row">
                <div class="col-md-6">
                    <h4>Indirizzo:</h4>
                    <p>Via della Pizzeria, 123, Roma</p>
                </div>
                <div class="col-md-6">
                    <h4>Telefono:</h4>
                    <p>+39 06 12345678</p>
                    <h4>Email:</h4>
                    <p>info@pizzeria.com</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center">
        <div class="container">
            <p>&copy; 2024 Pizzeria. Tutti i diritti riservati.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
