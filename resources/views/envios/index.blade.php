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
        var map = L.map('map').setView([-17.3895, -66.1568], 13); // Centra el mapa en el almacén del primer envío

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: 'Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
        }).addTo(map);

        @foreach ($envios as $envio)
            // Coordenadas del almacén y el cliente para el envío actual
            var almacenData = JSON.parse('{{ $envio->almacen }}');
            var clienteData = JSON.parse('{{ $envio->cliente }}');

            var almacenLat = almacenData.coordinates[1];
            var almacenLng = almacenData.coordinates[0];

            var clienteLat = clienteData.coordinates[1];
            var clienteLng = clienteData.coordinates[0];

            // Crea una línea entre el almacén y el cliente
            var latlngs = [
                [almacenLat, almacenLng],
                [clienteLat, clienteLng]
            ];

            var polyline = L.polyline(latlngs, { color: 'blue' }).addTo(map);

            // Agrega marcadores para el almacén y el cliente
            L.marker([almacenLat, almacenLng]).addTo(map).bindPopup('Almacén: {{ $envio->almacen->nombre }}');
            L.marker([clienteLat, clienteLng]).addTo(map).bindPopup('Cliente: {{ $envio->cliente->nombre }}');
        @endforeach

        // Ajusta la vista del mapa para que muestre todas las rutas
        var group = new L.featureGroup([
            @foreach ($envios as $envio)
                polyline{{ $envio->id }},
            @endforeach
        ]);
        map.fitBounds(group.getBounds());
        
    </script>
@endsection