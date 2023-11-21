<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class RutasController extends Controller
{
    public function seleccionarRutas()
    {
        $almacenes = Almacen::all();
        $clientes = Cliente::all();

        return view('seleccionarRutas', compact('almacenes', 'clientes'));
    }

    private function calcularRutaHere($origen, $destino)
{
    $apiKey = 'TU_CLAVE_DE_API_DE_HERE';
    $start = implode(',', $origen);
    $end = implode(',', $destino);

    $url = "https://router.hereapi.com/v8/routes?transportMode=car&origin=$start&destination=$end&apiKey=$apiKey";

    $client = new Client();

    try {
        $response = $client->get($url);

        $data = json_decode($response->getBody(), true);

        // Retorna las coordenadas de la ruta
        return $data['routes'][0]['sections'][0]['polyline'];
    } catch (\Exception $e) {
        // Captura y maneja errores
        return [];
    }
}


    private function calcularRutaOpenRouteService($origen, $destino)
{
    $apiKey = 'TU_CLAVE_DE_API_DE_OPENROUTESERVICE';
    $start = implode(',', $origen);
    $end = implode(',', $destino);

    $url = "https://api.openrouteservice.org/v2/directions/driving-car?api_key=$apiKey&start=$start&end=$end&format=geojson";

    $client = new Client();
    
    try {
        $response = $client->post($url);

        $data = json_decode($response->getBody(), true);

        // Retorna la geometría de la ruta
        return $data['features'][0]['geometry']['coordinates'];
    } catch (\Exception $e) {
        // Captura y maneja errores
        return [];
    }
}
}
