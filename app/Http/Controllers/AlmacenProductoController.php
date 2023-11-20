<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Almacen;
use App\Models\Producto;

class AlmacenProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($almacen_id)
    {
        //
        // Obtén el almacén por ID
        $almacen = Almacen::findOrFail($almacen_id);
        $productosEnAlmacen = $almacen->productos;
        return view('almacen_productos.index', compact('productosEnAlmacen', 'almacen'));
    

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($almacen_id)
    {
        //
        $almacen = Almacen::find($almacen_id);

        // Obtener todos los productos disponibles
        $productos = Producto::all();

        return view('almacen_productos.create', compact('almacen', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($almacen_id,Request $request)
    {
        //
        $request->validate([
            'productos' => 'required|array',
            'productos.*' => 'exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);
        $almacen = Almacen::find($almacen_id);
        $productosYaAsociados = $almacen->productos()->whereIn('productos.id', $request->input('productos'))->exists();
        if ($productosYaAsociados) {
            return redirect('almacenes/'.$almacen_id.'/productos')
                ->with('warning', 'Algunos productos ya están asociados al almacén.');
        }
        $almacen->productos()->attach(
            $request->input('productos'),
            ['cantidad' => $request->input('cantidad')]
        );
        return redirect('almacenes/'.$almacen_id.'/productos')
            ->with('success', 'Productos asignados correctamente al almacén.');
    }

    /**
     * Display the specified resource.
     */
    public function show($almacen_id,string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($almacen_id, $id)
    {
        //
        $almacen = Almacen::find($almacen_id);
        $producto = $almacen->productos()->findOrFail($id);
        return view('almacen_productos.create', compact('almacen', 'producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($almacen_id,Request $request, string $id)
    {
        //
        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        // Obtener el almacén por ID
        $almacen = Almacen::findOrFail($almacen_id);

        // Actualizar la cantidad del producto en el almacén
        $almacen->productos()->updateExistingPivot($id, ['cantidad' => $request->input('cantidad')]);

        // Redirigir a la vista del almacén con un mensaje de éxito
        return redirect('almacenes/'.$almacen_id.'/productos')
            ->with('success', 'Cantidad del producto actualizada correctamente en el almacén.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($almacen_id,string $id)
    {
        //
        $almacen = Almacen::findOrFail($almacen_id);
        $almacen->productos()->detach($id);
        return redirect('almacenes/'.$almacen_id.'/productos')
            ->with('success', 'Producto eliminado correctamente del almacén.');
    }
}
