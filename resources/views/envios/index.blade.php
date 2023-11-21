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

                            <!-- Script para mostrar la ruta en el mapa -->
                            <script>
                                var map{{ $envio->id }} = L.map('map-{{ $envio->id }}').setView([-17.3895, -66.1568], 13);

                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                }).addTo(map{{ $envio->id }});

                                var coordinates{{ $envio->id }} = {!! json_encode($envio->rutaCoordinates()) !!};

                                L.polyline(coordinates{{ $envio->id }}).addTo(map{{ $envio->id }});
                            </script>
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
        </table>
    </div>
@endsection
