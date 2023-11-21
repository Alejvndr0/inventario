<!-- En mostrarRuta.blade.php -->
@extends('layouts.crud')

@section('content')
    <style>
        #map {
            width: 100%;
            height: 400px;
        }
    </style>

    <div id="map"></div>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var map = L.map('map').setView([0, 0], 2);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            // Definir coordenadas de almacén y cliente
            var almacenLatitud = {{ $almacen->latitud }};
            var almacenLongitud = {{ $almacen->longitud }};
            var clienteLatitud = {{ $cliente->latitud }};
            var clienteLongitud = {{ $cliente->longitud }};

            // Marcadores de almacén y cliente
            var almacenMarker = L.marker([almacenLatitud, almacenLongitud]).addTo(map);
            var clienteMarker = L.marker([clienteLatitud, clienteLongitud]).addTo(map);

            // Ruta
            var rutaCoordinates = @json($ruta);

            // Añadir una polilínea para representar la ruta después de cargar la respuesta
            cargarRutaEnMapa(rutaCoordinates, map, almacenLatitud, almacenLongitud, clienteLatitud, clienteLongitud);
        });

        function cargarRutaEnMapa(rutaCoordinates, map, almacenLatitud, almacenLongitud, clienteLatitud, clienteLongitud) {
            if (rutaCoordinates.length > 0) {
                // Añadir una polilínea para representar la ruta
                var rutaPolyline = L.polyline(rutaCoordinates, { color: 'blue' }).addTo(map);

                // Ajustar el mapa para que abarque todos los elementos
                var bounds = L.latLngBounds([almacenLatitud, almacenLongitud], [clienteLatitud, clienteLongitud]);
                map.fitBounds(bounds);
            } else {
                // Manejar el caso en que la respuesta de la API no contiene coordenadas de ruta
                console.error('La respuesta de la API no contiene coordenadas de ruta.');
            }
        }
    </script>
@endsection
