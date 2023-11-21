@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Envíos</h1>
        <p>
            <a href="{{ route('envios.create') }}" class="btn btn-primary">Crear Envío</a>
        </p>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Almacén</th>
                    <th>Fecha de Entrega</th>
                    <th>Ruta en Mapa</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($envios as $envio)
                    <tr>
                        <td>{{ $envio->id }}</td>
                        <td>{{ $envio->cliente->nombre }}</td>
                        <td>{{ $envio->almacen->nombre }}</td>
                        <td>{{ $envio->fecha_entrega }}</td>
                        <td>
                            <!-- Mapa con ruta -->
                            <div id="map-{{ $envio->id }}" style="height: 100px;"></div>
                        </td>
                        <td>
                            <a href="{{ route('envios.edit', $envio->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('envios.destroy', $envio->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <div id="map" style="height: 600px;"></div>
        </table>
    </div>
    
<script>
    var map = L.map('map').setView([-17.3895, -66.1568], 13 );

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    @foreach ($envios as $envio)
        var lat_cli = {{ $envio->cliente->latitud }};
        var lng_cli = {{ $envio->cliente->longitud }};
        var lat_alm = {{ $envio->almacen->latitud }};
        var lng_alm = {{ $envio->almacen->longitud }};
        var randomColor = '#' + Math.floor(Math.random()*16777215).toString(16);
        L.Routing.control({
            waypoints:[
                L.latLng(lat_cli, lng_cli),
                L.latLng(lat_alm, lng_alm)
            ],
            routeWhileDragging: false, // Deshabilitar el enrutamiento mientras se arrastra
            draggableWaypoints: false, // Deshabilitar la capacidad de arrastrar puntos de ruta
            addWaypoints: false, // Deshabilitar la capacidad de agregar nuevos puntos de ruta
            lineOptions: {
                styles: [{color: randomColor, opacity: 1, weight: 6}]
            },
            show: false // Ocultar el control de enrutamiento
        }).addTo(map);
    @endforeach
</script>
@endsection
