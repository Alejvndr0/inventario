@extends('layouts.crud')

@section('content')
    <div class="container">
        <h1>Lista de Pedidos</h1>
        <a href="{{ route('pedidos.create') }}" class="btn btn-primary">Agregar Pedido</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Fecha del Pedido</th>
                    <th>Detalles del Pedido</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->id }}</td>
                        <td>{{ $pedido->cliente->nombre }}</td>
                        <td>{{ $pedido->fecha_pedido }}</td>
                        <td>
                            @foreach ($pedido->detalles as $detalle)
                                {{ $detalle->producto->nombre }}: {{ $detalle->cantidad }}<br>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('pedidos.edit', $pedido->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('pedidos.destroy', $pedido->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este pedido?')">Eliminar</button>
                            </form>
                            <!-- Agrega un botón para ver los detalles del pedido si es necesario -->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div id="map" style="height: 400px;"></div>

    <script>
        var map = L.map('map').setView([-17.390780, -66.139417], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Aquí debes proporcionar las coordenadas geográficas del cliente y el almacén
        var clienteCoords = [-17.391665, -66.141543];
        var almacenCoords = [-17.389393236257227, -66.141051];

        // Marcadores para el cliente y el almacén
        L.marker(clienteCoords).addTo(map).bindPopup('Cliente');
        L.marker(almacenCoords).addTo(map).bindPopup('Almacén');

        // Línea de ruta entre el cliente y el almacén
        var ruta = L.polyline([clienteCoords, almacenCoords], { color: 'red' });
        ruta.addTo(map);
    </script>
@endsection
