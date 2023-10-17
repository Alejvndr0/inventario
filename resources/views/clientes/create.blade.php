@extends('layouts.crud')

@section('content')
    <div class="container">
        <br>
        <h1>Agregar Cliente</h1>
        <br>
        <form method="POST" action="{{ route('clientes.store') }}">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre del cliente</label>
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
            <br>
            <div id="map" style="height: 400px;"></div>
            <br>
            <a href="{{ route('clientes.index') }}" class="btn btn-primary">volver</a>
            <button type="submit" class="btn btn-primary">Agregar cliente</button>
        </form>
        <br>
    </div>

    <script>
        var map = L.map('map').setView([-17.3895, -66.1568], 13);

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
