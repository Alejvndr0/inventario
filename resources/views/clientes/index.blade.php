@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de clientes</h1>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">Agregar clientes</a>
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
                @foreach ($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->id }}</td>
                        <td>{{ $cliente->nombre }}</td>
                        <td>{{ $cliente->direccion }}</td>
                        <td>{{ $cliente->ubicacion_texto }}</td>
                        <td>
                            <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning">Editar</a>
                            
                            <!-- Agregar botón para eliminar -->
                            <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este cliente?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        var map = L.map('map').setView([0, 0], 13); 

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        @foreach ($clientes as $cliente)
            var ubicacionText = "{{ $cliente->ubicacion_texto }}";
            var latLngArray = ubicacionText.match(/[\d.-]+/g);
            if (latLngArray.length === 2) {
                var lat = parseFloat(latLngArray[0]);
                var lng = parseFloat(latLngArray[1]);
                L.marker([lat, lng]).addTo(map)
                    .bindPopup("Nombre: {{ $cliente->nombre }}<br>Dirección: {{ $cliente->direccion }}")
                    .openPopup();
            }
        @endforeach
    </script>
@endsection
