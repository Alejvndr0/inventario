@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Almacenes</h1>
        <a href="{{ route('almacenes.create') }}" class="btn btn-primary">Agregar Almacén</a>
        <div id="map" style="height: 400px;"></div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Ubicación Geográfica</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($almacenes as $almacen)
                    <tr>
                        <td>{{ $almacen->id }}</td>
                        <td>{{ $almacen->nombre }}</td>
                        <td>{{ $almacen->direccion }}</td>
                        <td>{{ $almacen->ubicacion_texto }}</td>
                        <td>
                            <a href="{{ route('almacenes.show', $almacen->id) }}" class="btn btn-info">Ver</a>
                            <a href="{{ route('almacenes.edit', $almacen->id) }}" class="btn btn-warning">Editar</a>
                            <!-- Agregar botón para eliminar si lo deseas -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        var map = L.map('map').setView([0, 0], 13); // Cambia las coordenadas iniciales aquí

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        @foreach ($almacenes as $almacen)
            var ubicacionText = "{{ $almacen->ubicacion_texto }}";
            var latLngArray = ubicacionText.match(/[\d.-]+/g);
            if (latLngArray.length === 2) {
                var lat = parseFloat(latLngArray[0]);
                var lng = parseFloat(latLngArray[1]);
                L.marker([lat, lng]).addTo(map)
                    .bindPopup("Nombre: {{ $almacen->nombre }}<br>Dirección: {{ $almacen->direccion }}")
                    .openPopup();
            }
        @endforeach
    </script>
@endsection