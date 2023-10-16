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
            'almacenes' => 'array|required',
        ]);

        $producto = Producto::create($request->except('almacenes'));

        foreach ($request->almacenes as $almacenId) {
            StockEnAlmacen::create([
                'producto_id' => $producto->id,
                'almacen_id' => $almacenId,
                'cantidad' => $request->input('cantidad_' . $almacenId),
            ]);
        }

        return redirect()->route('productos.index');
    }

    public function edit($id)
    {
        $producto = Producto::find($id);
        $almacenes = Almacen::all();
        $almacenesSeleccionados = is_array($producto->stocks) ? $producto->stocks->pluck('almacen_id')->toArray() : [];
        $cantidades = is_array($producto->stocks) ? $producto->stocks->pluck('cantidad', 'almacen_id')->toArray() : [];

        return view('productos.edit', compact('producto', 'almacenes', 'almacenesSeleccionados', 'cantidades'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'almacenes' => 'array|required',
            'cantidad' => 'array|required',
        ]);

        $producto = Producto::find($id);

        if (!$producto) {
            return back()->with('error', 'Producto no encontrado');
        }

        $producto->update([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'precio' => $request->input('precio'),
        ]);

        $almacenesSeleccionados = $request->input('almacenes');
        $cantidades = $request->input('cantidad');

        // Actualiza los detalles del stock en almacén
        StockEnAlmacen::where('producto_id', $producto->id)->delete();

        foreach ($almacenesSeleccionados as $almacenId) {
            StockEnAlmacen::create([
                'producto_id' => $producto->id,
                'almacen_id' => $almacenId,
                'cantidad' => $cantidades[$almacenId],
            ]);
        }

        return redirect()->route('productos.index')->with('success', 'Producto actualizado exitosamente');
    }

    public function destroy($id)
    {
        $producto = Producto::find($id);

        if ($producto) {
            // Elimina los detalles del stock en almacén
            $producto->stocks()->delete();

            // Elimina el producto
            $producto->delete();
        }

        return redirect()->route('productos.index');
    }
}
