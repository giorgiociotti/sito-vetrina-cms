<head>
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
</head><form action="{{ route('pizza.update', $pizza->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="name">Nome:</label>
    <input type="text" id="name" name="name" value="{{ $pizza->name }}" required>

    <label for="description">Descrizione:</label>
    <textarea id="description" name="description" required>{{ $pizza->description }}</textarea>

    <label for="category">Categoria:</label>
    <select id="category" name="category" required>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ $pizza->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
        @endforeach
    </select>

    <label for="ingredients">Ingredienti:</label>
    <div id="ingredients">
        @foreach($ingredients as $ingredient)
            <div>
                <input type="checkbox" id="ingredient_{{ $ingredient->id }}" name="ingredients[]" value="{{ $ingredient->id }}" 
                    {{ in_array($ingredient->id, $pizza->ingredients->pluck('id')->toArray()) ? 'checked' : '' }}>
                <label for="ingredient_{{ $ingredient->id }}">{{ $ingredient->name }}</label>
            </div>
        @endforeach
    </div>

    <label for="image">Immagine:</label>
    <input type="file" id="image" name="image">

    <button type="submit">Aggiorna Pizza</button>
</form>
