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
    <!-- Navbar (opzionale) -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <a class="navbar-brand" href="#">Pizzeria</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contatti</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Form per aggiungere una nuova pizza, visibile solo agli amministratori -->
    @if(Auth::check() && Auth::user()->isAdmin())
    <div class="container mt-5">
        <div class="row">
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
                    <div class="form-group">
                        <label for="price">Prezzo (€)</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" placeholder="Inserisci il prezzo della pizza" value="{{ old('price') }}" step="0.01" required>
                        @error('price')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="category">Categoria</label>
                        @foreach ($categories as $category)
                            <div class="form-check">
                                <input class="form-check-input @error('category') is-invalid @enderror" type="radio" name="category" id="category{{ $category->id }}" value="{{ $category->id }}" {{ old('category') == $category->id ? 'checked' : '' }} required>
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

                    <div class="form-group">
                        <label for="ingredients">Ingredienti</label>
                        @forelse ($ingredients as $ingredient)
                            @if ($ingredient->name)
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

                    <div class="form-group">
                        <label for="image">Immagine</label>
                        <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image" required>
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
    @endif

    <!-- Footer -->
    <footer class="text-center">
        <p>&copy; 2024 Pizzeria Ecommerce. Tutti i diritti riservati.</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
