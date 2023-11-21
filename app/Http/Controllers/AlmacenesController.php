<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;

class AlmacenesController extends Controller
{
    public function index()
    {
        $almacenes = Almacen::all();

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
        $almacen->latitud = $request->input('latitud');
        $almacen->longitud = $request->input('longitud');
        $almacen->save();

        return redirect()->route('almacenes.index');
    }

    public function edit($id)
    {
        $almacen = Almacen::find($id);

        return view('almacenes.edit', compact('almacen'));
    }

    public function update(Request $request, $id)
    {
        $almacen = Almacen::find($id);
        $almacen->nombre = $request->input('nombre');
        $almacen->direccion = $request->input('direccion');
        $almacen->latitud = $request->input('latitud');
        $almacen->longitud = $request->input('longitud');
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
