<!-- resources/views/layout.blade.php -->
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Aggiungi i link CSS qui -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

    <!-- Header -->
    <header>
        @include('partials.header')
    </header>

    <!-- Contenuto principale -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        
        @include('partials.footer')
    </footer>

    <!-- Aggiungi script JS qui -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
