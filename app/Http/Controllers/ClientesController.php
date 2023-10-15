<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = DB::table('clientes')
            ->select('id', 'nombre', 'direccion', DB::raw("ST_AsText(ubicacion_geografica) as ubicacion_texto"))
            ->get();
    
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cliente = new Cliente();
    $cliente->nombre = $request->input('nombre');
    $cliente->direccion = $request->input('direccion');
    $latitud = $request->input('latitud');
    $longitud = $request->input('longitud');
    $ubicacion_geografica = "POINT($latitud $longitud)";

    $cliente->ubicacion_geografica = DB::raw("ST_GeomFromText('$ubicacion_geografica')");
    $cliente->save();

    return redirect()->route('clientes.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Obtén el almacén de la base de datos
    $cliente = Cliente::find($id);

    // Convierte la ubicación geográfica a coordenadas de latitud y longitud
    $ubicacion_geografica = DB::table('clientes')
        ->where('id', $id)
        ->select(DB::raw("ST_AsText(ubicacion_geografica) as ubicacion_texto"))
        ->first();

    // Analiza la ubicación_texto para obtener latitud y longitud
    list($latitud, $longitud) = sscanf($ubicacion_geografica->ubicacion_texto, 'POINT(%f %f)');

    // Pasa los datos del almacén, latitud y longitud a la vista
    return view('clientes.edit', compact('cliente', 'latitud', 'longitud'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Obtén el almacén existente
        $cliente = Cliente::find($id);

        // Actualiza los campos del almacén con los datos del formulario
        $cliente->nombre = $request->input('nombre');
        $cliente->direccion = $request->input('direccion');

        // Actualiza las coordenadas de latitud y longitud si se han modificado
        $latitud = $request->input('latitud');
        $longitud = $request->input('longitud');
        $ubicacion_geografica = "POINT($latitud $longitud)";

        $cliente->ubicacion_geografica = DB::raw("ST_GeomFromText('$ubicacion_geografica')");

        // Guarda los cambios en la base de datos
        $cliente->save();

        return redirect()->route('clientes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id);
        $cliente->delete();

        return redirect()->route('clientes.index');
    }
}
