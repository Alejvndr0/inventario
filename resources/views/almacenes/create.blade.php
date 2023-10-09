@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Agregar Almacén</h1>
        <form method="POST" action="{{ route('almacenes.store') }}">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre del Almacén</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <textarea name="direccion" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="latitud">Latitud</label>
                <input type="text" id="latitud" name="latitud" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="longitud">Longitud</label>
                <input type="text" id="longitud" name="longitud" class="form-control" required>
            </div>
            <div id="map" style="height: 400px;"></div>
            <button type="submit" class="btn btn-primary">Agregar Almacén</button>
        </form>
    </div>

    <script>
        var map = L.map('map').setView([51.505, -0.09], 13); // Establece una vista inicial en Londres

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker;
        var latitudInput = document.getElementById('latitud');
        var longitudInput = document.getElementById('longitud');

        map.on('click', function(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng).addTo(map);
            latitudInput.value = e.latlng.lat;
            longitudInput.value = e.latlng.lng;
        });
    </script>
@endsection