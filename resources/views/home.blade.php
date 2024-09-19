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

    <!-- Header -->
    <header class="header-bg">
        <div class="header-content">
            <h1>Benvenuto alla Pizzeria Online</h1>
            <p>Ordina la tua pizza preferita comodamente da casa</p>
            <a href="#menu" class="btn btn-primary btn-lg">Vedi il nostro menu</a>
        </div>
    </header>

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
                                <p class="card-text">{{ $pizza->description }}</p>
                                <a href="{{ route('pizza.show', ['id' => $pizza->id]) }}" class="btn btn-primary">Dettagli</a>
                                <a href="#" class="btn btn-primary">Aggiungi al carrello</a>
                                
                                <!-- Modulo di cancellazione -->
                                <form action="{{ route('pizzas.destroy', ['id' => $pizza->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Sei sicuro di voler eliminare questa pizza?')">Elimina</button>
                                </form>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Form per aggiungere una nuova pizza -->
            <div class="row mt-5">
                <div class="col-md-12">
                    <h3>Aggiungi una nuova pizza</h3>
                    <form method="POST" action="{{ route('pizzas.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nome della Pizza</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Inserisci il nome della pizza" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Descrizione</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Descrivi la pizza" required>{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Radio Buttons per le categorie -->
                        <div class="form-group">
                            <label for="category">Categoria</label>
                            @foreach ($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input @error('category') is-invalid @enderror" type="radio" name="category" id="category{{ $category->id }}" value="{{ $category->id }}" {{ old('category') == $category->id ? 'checked' : '' }} >
                                    <label class="form-check-label" for="category{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach
                            @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Checkbox per gli ingredienti -->
                        <div class="form-group">
                            <label for="ingredients">Ingredienti</label>
                            @forelse ($ingredients as $ingredient)
                                @if ($ingredient->name) <!-- Verifica se il campo 'name' non è vuoto -->
                                    <div class="form-check">
                                        <input class="form-check-input @error('ingredients') is-invalid @enderror" type="checkbox" name="ingredients[]" id="ingredient{{ $ingredient->id }}" value="{{ $ingredient->id }}" {{ in_array($ingredient->id, old('ingredients', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="ingredient{{ $ingredient->id }}">
                                            {{ $ingredient->name }}
                                        </label>
                                    </div>
                                @endif
                            @empty
                                <p>Nessun ingrediente disponibile.</p>
                            @endforelse
                            @error('ingredients')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Input per caricare un'immagine -->
                        <div class="form-group">
                            <label for="image">Immagine</label>
                            <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image">
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success">Aggiungi Pizza</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

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
