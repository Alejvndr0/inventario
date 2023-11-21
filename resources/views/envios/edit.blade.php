@extends('layouts.crud')

@section('content')
    <div class="container">
        <br>
        <h1>Editar Envío</h1>
        <form method="POST" action="{{ route('envios.update', $envio->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="cliente_id">Cliente</label>
                <select id="cliente_id" name="cliente_id" class="form-control" required>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}" @if ($envio->cliente_id == $cliente->id) selected @endif>{{ $cliente->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="almacen_id">Almacén</label>
                <select id="almacen_id" name="almacen_id" class="form-control" required>
                    @foreach ($almacenes as $almacen)
                        <option value="{{ $almacen->id }}" @if ($envio->almacen_id == $almacen->id) selected @endif>{{ $almacen->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_entrega">Fecha de Entrega</label>
                <input type="date" id="fecha_entrega" name="fecha_entrega" class="form-control" value="{{ $envio->fecha_entrega }}" required>
            </div>

            <!-- Map for selecting and displaying route -->
            <div id="map" style="height: 400px;"></div>

            <!-- Hidden fields for storing coordinates -->
            <input type="hidden" id="latitud_cliente" name="latitud_cliente" value="{{ $envio->rutaCoordinates()[0][0] ?? '' }}">
            <input type="hidden" id="longitud_cliente" name="longitud_cliente" value="{{ $envio->rutaCoordinates()[0][1] ?? '' }}">
            <input type="hidden" id="latitud_almacen" name="latitud_almacen" value="{{ $envio->rutaCoordinates()[1][0] ?? '' }}">
            <input type="hidden" id="longitud_almacen" name="longitud_almacen" value="{{ $envio->rutaCoordinates()[1][1] ?? '' }}">

            <br>
            <a href="{{ route('envios.index') }}" class="btn btn-primary">Volver</a>
            <button type="submit" class="btn btn-primary">Actualizar Envío</button>
        </form>
        <br>
    </div>

    <script>
        var map = L.map('map').setView([{{ $envio->rutaCoordinates()[0][0] ?? -17.3895 }}, {{ $envio->rutaCoordinates()[0][1] ?? -66.1568 }}], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var marker = L.marker([{{ $envio->rutaCoordinates()[0][0] ?? -17.3895 }}, {{ $envio->rutaCoordinates()[0][1] ?? -66.1568 }}]).addTo(map);

        map.on('click', function(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng).addTo(map);

            // Update hidden fields with selected coordinates
            document.getElementById('latitud_cliente').value = e.latlng.lat;
            document.getElementById('longitud_cliente').value = e.latlng.lng;
        });
    </script>
@endsection
