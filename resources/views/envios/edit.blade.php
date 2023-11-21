
@extends('layouts.crud')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if (isset($envio))
                    <div class="card-header">Editar envio N°:{{$envio->id}}</div>
                @else
                    <div class="card-header">Crear envio</div>
                @endif
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (isset($envio))
                        <form method="POST" action="{{url('envios/'.$envio->id)}}">
                    @else
                        <form method="POST" action="{{url('envios')}}">
                    @endif
                        @if(isset($envio))
                            @method('PUT')
                        @endif
                        
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
                        @if (isset($envio))
                            <div id="map" style="height: 400px;"></div>
                            <input type="hidden" name="ruta" id="ruta" value="{{ $envio->ruta ?? '' }}">
                        @endif
                        @if (isset($envio))
                            <div>
                                <!--<input type="submit" name="botonsito" value="Editar">-->
                                <button type="submit" class="btn btn-success" name="botonsito">Editar</button>
                            </div>
                        @else
                            <div>
                                <button type="submit" class="btn btn-success" name="botonsito">Crear</button>
                            </div>
                        @endif
                        @csrf
                    </form>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>
<script>
    var map = L.map('map').setView([-17.3895, -66.1568], 13 );

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
        var lat_cli = {{ $envio->cliente->latitud }};
        var lng_cli = {{ $envio->cliente->longitud }};
        var lat_alm = {{ $envio->almacen->latitud }};
        var lng_alm = {{ $envio->almacen->longitud }};
        var control = L.Routing.control({
            waypoints: [
            L.latLng(lat_cli, lng_cli),
            L.latLng(lat_alm, lng_alm)
            ],
        }).addTo(map);
        control.on('waypointschanged', function (e) {
        // Obtener los waypoints actualizados y convertirlos a un formato para almacenar en el campo oculto
        var ruta = e.waypoints.map(function(waypoint) {
            return waypoint.latLng.lat + ' ' + waypoint.latLng.lng;
        }).join(',');

        // Actualizar el valor del campo oculto
        console.log(ruta);
        document.getElementById('ruta').value = ruta;
    })
        map.on('click', function (e) {
    control.spliceWaypoints(control.getWaypoints().length - 1, 1, e.latlng);
});

map.on('contextmenu', function (e) {
    // Obtén el índice del punto más cercano al lugar del clic derecho
    var index = control.getWaypoints().reduce(function (acc, waypoint, i) {
        var distance = e.latlng.distanceTo(waypoint.latLng);
        return distance < acc.distance ? { index: i, distance: distance } : acc;
    }, { index: -1, distance: Infinity }).index;

    // Si se encontró un punto cercano, elimínalo
    if (index !== -1) {
        control.spliceWaypoints(index, 1);
    }
});
            /*createMarker: function(i, waypoint, n) {
                // Personaliza la apariencia de los marcadores intermedios si es necesario
            }
            
        }).addTo(map);
        control.getWaypoints().forEach(function(waypoint) {
        waypoint.marker.dragging.disable();
        });*/ 
</script>
@endsection
