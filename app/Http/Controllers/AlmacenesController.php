<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use Illuminate\Support\Facades\DB;

class AlmacenesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $almacenes = DB::table('almacenes')
            ->select('id', 'nombre', 'direccion', DB::raw("ST_AsText(ubicacion_geografica) as ubicacion_texto"))
            ->get();
    
        return view('almacenes.index', compact('almacenes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('almacenes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
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

    // Resto del código del controlador...
}