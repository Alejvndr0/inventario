<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Envio;
use App\Models\Almacen;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

class EnviosController extends Controller
{
    public function index()
    {
        $envios = Envio::with('cliente', 'almacen')->get();

        return view('envios.index', compact('envios'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $almacenes = Almacen::all();

        return view('envios.create', compact('clientes', 'almacenes'));
    }

    public function store(Request $request)
    {
        $envio = new Envio();
        $envio->cliente_id = $request->input('cliente_id');
        $envio->almacen_id = $request->input('almacen_id');
        $envio->fecha_entrega = $request->input('fecha_entrega');

        // Convert coordinates to LINESTRING format
        $latitudCliente = $request->input('latitud_cliente');
        $longitudCliente = $request->input('longitud_cliente');
        $latitudAlmacen = $request->input('latitud_almacen');
        $longitudAlmacen = $request->input('longitud_almacen');

        $routeCoordinates = [
            "$latitudCliente $longitudCliente",
            "$latitudAlmacen $longitudAlmacen"
        ];

        $envio->ruta = DB::raw("ST_GeomFromText('LINESTRING(" . implode(',', $routeCoordinates) . ")')");

        $envio->save();

        return redirect()->route('envios.index');
    }

    public function edit($id)
    {
        $envio = Envio::with('cliente', 'almacen')->find($id);
        $clientes = Cliente::all();
        $almacenes = Almacen::all();

        return view('envios.edit', compact('envio', 'clientes', 'almacenes'));
    }

    public function update(Request $request, $id)
    {
        $envio = Envio::find($id);
        $envio->cliente_id = $request->input('cliente_id');
        $envio->almacen_id = $request->input('almacen_id');
        $envio->fecha_entrega = $request->input('fecha_entrega');

        // Convert coordinates to LINESTRING format
        $latitudCliente = $request->input('latitud_cliente');
        $longitudCliente = $request->input('longitud_cliente');
        $latitudAlmacen = $request->input('latitud_almacen');
        $longitudAlmacen = $request->input('longitud_almacen');

        $routeCoordinates = [
            "$latitudCliente $longitudCliente",
            "$latitudAlmacen $longitudAlmacen"
        ];

        $envio->ruta = DB::raw("ST_GeomFromText('LINESTRING(" . implode(',', $routeCoordinates) . ")')");

        $envio->save();

        return redirect()->route('envios.index');
    }

    public function destroy($id)
    {
        $envio = Envio::find($id);
        $envio->delete();

        return redirect()->route('envios.index');
    }
}
