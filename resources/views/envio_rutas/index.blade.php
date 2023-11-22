@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Envíos</h1>
        <p>
            <a href="{{ route('envios.index') }}" class="btn btn-primary">Atras</a>
        </p>
        <div id="map" style="height: 700px;"></div>
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
        var randomColor = '#' + Math.floor(Math.random()*16777215).toString(16);
        var control=L.Routing.control({
            waypoints:[
                L.latLng(lat_cli, lng_cli),
                L.latLng(lat_alm, lng_alm)
            ],
            lineOptions: {
                styles: [{color: randomColor, opacity: 1, weight: 6}]
            },
            language: 'es',
        }).addTo(map);
        function calcularTiempoAjustado(distanciaTotal) {
        var incrementoMetros = 150;
        var incrementoSegundos = 15;

        var tiempoAjustado = 0;

        for (var i = 0; i < distanciaTotal; i += incrementoMetros) {
            tiempoAjustado += incrementoSegundos;
        }

        return tiempoAjustado;
    }

    control.on('routeselected', function (e) {
        var route = e.route;
        var distanciaTotal = route.summary.totalDistance; // en metros
        var tiempoAjustado = calcularTiempoAjustado(distanciaTotal);

        // Muestra el tiempo de llegada ajustado en la consola (puedes hacer lo que quieras con esta información)
        console.log("Tiempo de llegada ajustado: " + tiempoAjustado + " segundos");
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
</script>
@endsection
