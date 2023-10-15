<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu título aquí</title>
    <!-- Agrega los enlaces a los archivos CSS de Leaflet -->
    <link
      rel="stylesheet"
      href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
      integrity="sha384-7ik9qqx7w5dtaG5qIbtb5lWhefcyGOGC5j3S8p3+z/7MG8ORkTtoF9b5eRYZtTUNJ"
      crossorigin=""
    />

    <!-- Agrega los enlaces a los archivos JS de Leaflet -->
    <script
      src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
      integrity="sha384-k2p5ad9g35p+R2P5Op4FqFjcJ6pajs/rfdfs3SO+kF5mPIez2im+8U5C6Zyk5ahd7"
      crossorigin=""
    ></script>
</head>
<body>
    @yield('content')

    <!-- Agrega el código para inicializar el mapa Leaflet en tus vistas -->
    @yield('scripts')
</body>
</html>
