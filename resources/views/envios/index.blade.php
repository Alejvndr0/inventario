@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Envios</h1>
        <a href="{{ route('envios.create') }}" class="btn btn-primary">Agregar Envio</a>
        <div id="map" style="height: 400px;"></div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Almacen de entrega</th>
                    <th>Cliente</th>
                    <th>Fecha de entrega</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($envios as $envio)
                    <tr>
                        <td>{{ $envio->id }}</td>
                        <td>{{ $envio->almacen->nombre }}</td>
                        <td>{{ $envio->cliente->nombre }}</td>
                        <td>{{ $envio->fecha_entrega }}</td>
                        <td>
                            <a href="{{ route('envios.create', $envio->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('envios.destroy', $envio->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este envio?')">Eliminar</button>
                            </form>
                            <!-- Agrega un botón para ver los detalles del pedido si es necesario -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <script>
        var map = L.map('map').setView([-17.3895, -66.1568], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        @foreach($envios as $envio)
        var clienteUbicacion = L.latLng({{ $envio->cliente->ubicacion_geografica }});
        var almacenUbicacion = L.latLng({{ $envio->almacen->ubicacion_geografica }});


            // Calcular coordenadas intermedias
            var numPuntosIntermedios = 50;
            var coordsIntermedias = [];
            var lat1 = clienteUbicacion[0];
            var lon1 = clienteUbicacion[1];
            var lat2 = almacenUbicacion[0];
            var lon2 = almacenUbicacion[1];
            for (var i = 0; i < numPuntosIntermedios; i++) {
                var f = i / (numPuntosIntermedios - 1);
                var lat = lat1 + f * (lat2 - lat1);
                var lon = lon1 + f * (lon2 - lon1);
                coordsIntermedias.push([lat, lon]);
            }

            var ruta = L.polyline(coordsIntermedias, { color: 'blue' }).addTo(map);

            // Añadir marcadores para los puntos de inicio y final
            L.marker(clienteUbicacion).addTo(map);
            L.marker(almacenUbicacion).addTo(map);
        @endforeach

        var bounds = new L.LatLngBounds();
        @foreach($envios as $envio)
            bounds.extend(clienteUbicacion);
            bounds.extend(almacenUbicacion);
        @endforeach
        map.fitBounds(bounds);
    </script>

@endsection