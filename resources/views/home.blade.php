@extends('layouts.pru')

@section('content')
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>LACTEOS DORADOS</h3>
        </div>
        <br>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="{{ route('almacenes.index') }}">
                    ALMACENES
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('clientes.index') }}">
                    CLIENTES
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('productos.index') }}">
                    PRODUCTOS
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('envios.index') }}">
                    ENVIOS
                </a>
            </li>
        </ul>
    </nav>
    <div id="map" style="height: 400px;"></div>
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
        @foreach ($clientes as $cliente)
            var lat = {{ $cliente->latitud }};
            var lng = {{ $cliente->longitud }};
            L.marker([lat, lng]).addTo(map)
                .bindPopup("Nombre: {{ $cliente->nombre }}<br>Dirección: {{ $cliente->direccion }}")
                .openPopup();
        @endforeach
    </script>
@endsection
