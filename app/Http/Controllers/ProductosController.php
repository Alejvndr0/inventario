<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\StockEnAlmacen;
use App\Models\Almacen;

class ProductosController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $almacenes = Almacen::all();
        return view('productos.create', compact('almacenes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
        ]);

        $producto = Producto::create($request->all());

        return redirect()->route('productos.index');
    }

    public function edit($id)
    {
        $producto = Producto::find($id);
        $almacenes = Almacen::all();

        return view('productos.edit', compact('producto', 'almacenes', 'almacenesSeleccionados', 'cantidades'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
        ]);

        $producto = Producto::find($id);

        $producto->update([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'precio' => $request->input('precio'),
        ]);


        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente');
    }

    public function destroy($id)
    {
        $producto = Producto::find($id);

        if ($producto) {
            // Elimina los detalles del stock en almacén
            $producto->almacenes()->delete();

            // Elimina el producto
            $producto->delete();
        }

        return redirect()->route('productos.index');
    }
}
