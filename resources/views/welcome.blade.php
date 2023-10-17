<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/home.css'])

    <title>Bienvenidos a lacteos dorados</title>

    <!-- Styles -->
    <style>
        .bg-custom {
            background-color: #f0f0f0;
        }
    </style>
</head>

<body class="bg-custom">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            @if (Route::has('login'))
                <div class="d-flex">
                    @auth
                        <a href="{{ url('/home') }}" class="btn btn-primary me-2">Ir a la Tienda</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-secondary me-2">Iniciar Sesión</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn btn-secondary">Registrarse</a>
                        @endif
                    @endauth
                </div>
            @endif
        </div>
    </nav>

    <div class="container text-center py-5">
        <h1 class="display-4 fw-bold text-dark">¡Bienvenidos a lacteos dorados !</h1>
        <p class="lead text-secondary">Ofreciendo productos lácteos frescos y deliciosos para su hogar o negocio.</p>
    </div>



</body>

</html>
