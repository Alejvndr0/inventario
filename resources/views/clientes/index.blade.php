@extends('layouts.crud')

@section('content')
    <div class="container">
        <br>
        <h1>Lista de clientes</h1>
        <br>
        <a href="{{ route('home') }}" class="btn btn-primary">Inicio</a>
        <a href="{{ route('clientes.create') }}" class="btn btn-primary">Agregar cliente</a>
        <br>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Latitud</th>
                    <th>Longitud</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->id }}</td>
                        <td>{{ $cliente->nombre }}</td>
                        <td>{{ $cliente->direccion }}</td>
                        <td>{{ $cliente->latitud }}</td>
                        <td>{{ $cliente->longitud }}</td>
                        <td>
                            <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning">Editar</a>

                            <!-- Agregar botón para eliminar -->
                            <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este cliente?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <div id="map" style="height: 400px;"></div>
        <br>
    </div>

    <script>
        var map = L.map('map').setView([-17.3895, -66.1568], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        @foreach ($clientes as $cliente)
            var lat = {{ $cliente->latitud }};
            var lng = {{ $cliente->longitud }};
            L.marker([lat, lng]).addTo(map)
                .bindPopup("Nombre: {{ $cliente->nombre }}<br>Dirección: {{ $cliente->direccion }}")
                .openPopup();
        @endforeach
    </script>
@endsection
