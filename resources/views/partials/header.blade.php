@exextends('app.blade.php')
@sesection('header')<header class="header-bg">
        <div class="header-content">
            <h1>Benvenuto alla Pizzeria Online</h1>
            <p>Ordina la tua pizza preferita comodamente da casa</p>
            <a href="#menu" class="btn btn-primary btn-lg">Vedi il nostro menu</a>
        </div>
    </header>
	   <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script><!-- Bootstrap CSS -->
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
    @endsection