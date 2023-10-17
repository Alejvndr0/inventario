<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Cliente;
use App\Models\Envio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnviosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $envios = Envio::with('almacen','cliente')->get();

        foreach ($envios as $envio) {
            $geojsonAlmacen = DB::select("SELECT ST_AsGeoJSON('" . $envio->almacen->ubicacion_geografica . "') as geojson")[0]->geojson;
            $geojsonCliente = DB::select("SELECT ST_AsGeoJSON('" . $envio->cliente->ubicacion_geografica . "') as geojson")[0]->geojson;

        }

        return view('envios.index', compact('envios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $envios= Envio::all();
        $clientes = Cliente::all();
        $almacenes = Almacen::all();
        return view('envios.create', compact('clientes', 'almacenes', 'envios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'almacen_id' => 'required|exists:almacenes,id',
            'fecha_entrega' => 'required|date',
            
        ]);
        $envio = new Envio([
            'cliente_id' => $request->input('cliente_id'),
            'almacen_id' => $request->input('almacen_id'),
            'fecha_entrega' => $request->input('fecha_entrega'),
        ]);

        $envio->save();

        // Redirecciona a la vista de detalle del envío recién creado

        return redirect()->route('envios.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}