<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use Illuminate\Support\Facades\DB;

class AlmacenesController extends Controller
{
    public function index()
    {
        $almacenes = DB::table('almacenes')
            ->select('id', 'nombre', 'direccion', DB::raw("ST_AsText(ubicacion_geografica) as ubicacion_texto"))
            ->get();

        return view('almacenes.index', compact('almacenes'));
    }

    public function create()
    {
        return view('almacenes.create');
    }

    public function store(Request $request)
    {
        $almacen = new Almacen();
        $almacen->nombre = $request->input('nombre');
        $almacen->direccion = $request->input('direccion');
        $latitud = $request->input('latitud');
        $longitud = $request->input('longitud');
        $ubicacion_geografica = "POINT($latitud $longitud)";

        $almacen->ubicacion_geografica = DB::raw("ST_GeomFromText('$ubicacion_geografica')");
        $almacen->save();

        return redirect()->route('almacenes.index');
    }
    public function edit($id)
    {
        // Obtén el almacén de la base de datos
        $almacen = Almacen::find($id);

        // Convierte la ubicación geográfica a coordenadas de latitud y longitud
        $ubicacion_geografica = DB::table('almacenes')
            ->where('id', $id)
            ->select(DB::raw("ST_AsText(ubicacion_geografica) as ubicacion_texto"))
            ->first();

        // Analiza la ubicación_texto para obtener latitud y longitud
        list($latitud, $longitud) = sscanf($ubicacion_geografica->ubicacion_texto, 'POINT(%f %f)');

        // Pasa los datos del almacén, latitud y longitud a la vista
        return view('almacenes.edit', compact('almacen', 'latitud', 'longitud'));
    }

    public function update(Request $request, $id)
    {
        // Obtén el almacén existente
        $almacen = Almacen::find($id);

        // Actualiza los campos del almacén con los datos del formulario
        $almacen->nombre = $request->input('nombre');
        $almacen->direccion = $request->input('direccion');

        // Actualiza las coordenadas de latitud y longitud si se han modificado
        $latitud = $request->input('latitud');
        $longitud = $request->input('longitud');
        $ubicacion_geografica = "POINT($latitud $longitud)";

        $almacen->ubicacion_geografica = DB::raw("ST_GeomFromText('$ubicacion_geografica')");

        // Guarda los cambios en la base de datos
        $almacen->save();

        return redirect()->route('almacenes.index');
    }

    public function destroy($id)
    {
        $almacen = Almacen::find($id);
        $almacen->delete();

        return redirect()->route('almacenes.index');
    }
}