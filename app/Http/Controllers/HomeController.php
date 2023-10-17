<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $almacenes = DB::table('almacenes')
        ->select('id', 'nombre', 'direccion', DB::raw("ST_AsText(ubicacion_geografica) as ubicacion_texto"))
        ->get();
        $clientes = DB::table('clientes')
            ->select('id', 'nombre', 'direccion', DB::raw("ST_AsText(ubicacion_geografica) as ubicacion_texto"))
            ->get();
        return view('home',compact('almacenes','clientes'));
    }
}
