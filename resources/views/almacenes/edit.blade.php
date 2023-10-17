@extends('layouts.crud')

@section('content')
    <div class="container">
        <br>
        <h1>Editar Almacén</h1>
        <br>
        <form method="POST" action="{{ route('almacenes.update', $almacen->id) }}">
            @csrf
            @method('PUT') <!-- Usa el método PUT para actualizar el recurso -->

            <div class="form-group">
                <label for="nombre">Nombre del Almacén</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="{{ $almacen->nombre }}" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <textarea id="direccion" name="direccion" class="form-control" required>{{ $almacen->direccion }}</textarea>
            </div>
            <div class="form-group">
                <label for="latitud">Latitud</label>
                <input type="text" id="latitud" name="latitud" class="form-control" value="{{ $latitud }}"
                    required>
            </div>
            <div class="form-group">
                <label for="longitud">Longitud</label>
                <input type="text" id="longitud" name="longitud" class="form-control" value="{{ $longitud }}"
                    required>
            </div>
            <br>
            <div id="map" style="height: 400px;"></div>
            <br>
            <a href="{{ route('almacenes.index') }}" class="btn btn-primary">volver</a>
            <button type="submit" class="btn btn-primary">Actualizar Almacén</button>
        </form>
        <br>
    </div>

    <script>
        console.log("Latitud inicial:", {{ $latitud }});
        console.log("Longitud inicial:", {{ $longitud }});

        var map = L.map('map').setView([{{ $latitud }}, {{ $longitud }}], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker([{{ $latitud }}, {{ $longitud }}]).addTo(map);

        map.on('click', function(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng).addTo(map);
            document.getElementById('latitud').value = e.latlng.lat;
            document.getElementById('longitud').value = e.latlng.lng;

            console.log("Latitud al hacer clic:", e.latlng.lat);
            console.log("Longitud al hacer clic:", e.latlng.lng);
        });
    </script>
@endsection
