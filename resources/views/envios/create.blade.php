@extends('layouts.crud')

@section('content')
<div class="container">
  <br>
  <h1>Agregar Envío</h1>
  <form method="POST" action="{{ route('envios.store') }}">
    @csrf

    <div class="form-group">
      <label for="cliente_id">Cliente</label>
      <select id="cliente_id" name="cliente_id" class="form-control" required>
        @foreach ($clientes as $cliente)
          <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="almacen_id">Almacén</label>
      <select id="almacen_id" name="almacen_id" class="form-control" required>
        @foreach ($almacenes as $almacen)
          <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="fecha_entrega">Fecha de Entrega</label>
      <input type="date" id="fecha_entrega" name="fecha_entrega" class="form-control" required>
    </div>

    <div id="map" style="height: 400px;"></div>

    <br>
    <a href="{{ route('envios.index') }}" class="btn btn-primary">Volver</a>
    <button type="submit" class="btn btn-primary">Agregar Envío</button>
  </form>
  <br>
</div>

<script>
var map = L.map('map').setView([-17.3895, -66.1568], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

var clientMarker;
var almacenMarker;

// Inicializa los marcadores fuera del controlador de eventos de clic
var clienteId = document.getElementById('cliente_id').value;
var clienteObj = clientes.find(c => c.id === clienteId);
clientMarker = L.marker([clienteObj.latitud, clienteObj.longitud]).addTo(map);

var almacenId = document.getElementById('almacen_id').value;
var almacenObj = almacenes.find(a => a.id === almacenId);
almacenMarker = L.marker([almacenObj.latitud, almacenObj.longitud]).addTo(map);

map.on('click', function(e) {
  // Actualiza las posiciones de los marcadores
  clientMarker.setLatLng(e.latlng);
  almacenMarker.setLatLng(e.latlng);

  // Actualiza los campos ocultos con las coordenadas de clic
  document.getElementById('latitud_cliente').value = e.latlng.lat;
  document.getElementById('longitud_cliente').value = e.latlng.lng;
  document.getElementById('latitud_almacen').value = e.latlng.lat;
  document.getElementById('longitud_almacen').value = e.latlng.lng;

  // Elimina cualquier polilínea existente
  map.removeLayer(rutaPolyline);

  // Crea la polilínea de ruta
  var rutaPolyline = L.polyline([
    [clientMarker.getLatLng().lat, clientMarker.getLatLng().lng],
    [almacenMarker.getLatLng().lat, almacenMarker.getLatLng().lng]
  ]);

  // Agrega la polilínea al mapa
  rutaPolyline.addTo(map);
});
</script>

@endsection
