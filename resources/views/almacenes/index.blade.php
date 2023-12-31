@extends('layouts.crud')

@section('content')
    <div class="container">
        <br>
        <h1>ALMACENES</h1>
        <br>
        <a href="{{ route('home') }}" class="btn btn-primary">Inicio</a>
        <a href="{{ route('almacenes.create') }}" class="btn btn-primary">Agregar Almacén</a>
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
                @foreach ($almacenes as $almacen)
                    <tr>
                        <td>{{ $almacen->id }}</td>
                        <td>{{ $almacen->nombre }}</td>
                        <td>{{ $almacen->direccion }}</td>
                        <td>{{ $almacen->latitud }}</td>
                        <td>{{ $almacen->longitud }}</td>
                        <td>
                            <a href="{{ route('almacenes.edit', $almacen->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('almacenes.destroy', $almacen->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este almacén?')">Eliminar</button>
                            </form>
                            <a href="{{ url('almacenes/'.$almacen->id.'/productos') }}" class="btn btn-warning">Productos</a>
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

        @foreach ($almacenes as $almacen)
            var lat = {{ $almacen->latitud }};
            var lng = {{ $almacen->longitud }};
            L.marker([lat, lng]).addTo(map)
                .bindPopup("Nombre: {{ $almacen->nombre }}<br>Dirección: {{ $almacen->direccion }}")
                .openPopup();
        @endforeach
    </script>
@endsection
