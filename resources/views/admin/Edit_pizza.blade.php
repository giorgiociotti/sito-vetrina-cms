<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica Pizza</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 56px;
            background-color: #f8f9fa;
        }
        .header-bg {
            background: url('/images/pizza-banner.jpg') no-repeat center center;
            background-size: cover;
            height: 60vh;
            color: white;
            text-align: center;
            padding: 100px 0;
        }
        .form-container {
            background-color: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
        }
        .form-label {
            font-weight: bold;
        }
        .btn-custom {
            background-color: #28a745;
            color: white;
        }
        .btn-custom:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="header-bg">
    <h1>Modifica Pizza</h1>
</div>

<div class="container form-container mt-4">
    <form action="{{ route('pizza.update', $pizza->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name" class="form-label">Nome:</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $pizza->name }}" required>
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Descrizione:</label>
            <textarea id="description" name="description" class="form-control" required>{{ $pizza->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="category" class="form-label">Categoria:</label>
            <select id="category" name="category" class="form-control" required>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $pizza->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="price" class="form-label">Prezzo (€):</label>
            <input type="number" id="price" name="price" class="form-control" step="0.01" value="{{ $pizza->price }}" required>
        </div>

        <fieldset class="form-group">
            <legend class="form-label">Ingredienti:</legend>
            @foreach($ingredients as $ingredient)
                <div class="form-check">
                    <input type="checkbox" id="ingredient_{{ $ingredient->id }}" name="ingredients[]" class="form-check-input" value="{{ $ingredient->id }}" 
                        {{ in_array($ingredient->id, $pizza->ingredients->pluck('id')->toArray()) ? 'checked' : '' }}>
                    <label for="ingredient_{{ $ingredient->id }}" class="form-check-label">{{ $ingredient->name }}</label>
                </div>
            @endforeach
        </fieldset>

        <div class="form-group">
            <label for="image" class="form-label">Immagine:</label>
            <input type="file" id="image" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-custom">Aggiorna Pizza</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
