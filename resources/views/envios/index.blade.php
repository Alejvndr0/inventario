@extends('layouts.app')

@section('content')
    <div >
        <h1>Envíos</h1>
        <p>
            <a href="{{ route('envios.create') }}" class="btn btn-primary">Crear Envío</a>
            <a href="{{ route('home') }}" class="btn btn-primary">Inicio</a>
        </p>
        <table class="table">
            <thead class="text-center">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Almacén</th>
                    <th>Fecha de Entrega</th>
                    <th>Repartidor</th>
                    <th>Productos</th>
                    <th>Cantidad Total</th>
                    <th>Precio Total</th>
                    <th>Detalles</th>
                    <th>Estado</th>
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
                        <td>{{ $envio->user->name }}</td>
                        <td>
                            <ul>
                                @foreach($envio->productos as $producto)
                                    <li>
                                        {{ $producto->nombre }} -
                                        Cantidad: {{ $producto->pivot->cantidad }} -
                                        Precio unitario: ${{ $producto->precio }} -
                                        Precio total: ${{ $producto->precio * $producto->pivot->cantidad }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>{{ $envio->productos->sum('pivot.cantidad') }}</td>
                        <td>${{ $envio->productos->sum(function($producto) {
                            return $producto->precio * $producto->pivot->cantidad;
                        }) }}
                        </td>
                        <td>{{ $envio->detalles }}</td>
                        <td>{{ $envio->estado }}</td>
                        <td>
                            <a href="{{ route('envios.edit', $envio->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('envios.destroy', $envio->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                            </form>
                            <a href="{{url('envios/'.$envio->id.'/rutas')}}" class="btn btn-success">Rutas</a>
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
