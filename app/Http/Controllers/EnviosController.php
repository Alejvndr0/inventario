<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Envio;
use App\Models\Almacen;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\User;
use App\Models\EnvioProducto;
use Illuminate\Support\Facades\DB;

class EnviosController extends Controller
{
    public function index()

    {
        $envios = Envio::with('cliente', 'almacen', 'user')->get();

        return view('envios.index', compact('envios'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $almacenes = Almacen::all();
        $productos = Producto::all();
        $usuarios = User::all();

        return view('envios.edit', compact('clientes', 'almacenes', 'productos','usuarios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required',
            'almacen_id' => 'required',
            'user_id' => 'required',
            'fecha_entrega' => 'required|date',
            'productos' => 'required|array|min:1',
        ]);
        $envio = Envio::create([
            'cliente_id' => $request->cliente_id,
            'almacen_id' => $request->almacen_id,
            'user_id' => $request->user_id,
            'fecha_entrega' => $request->fecha_entrega,
            'detalles' => $request->detalles,
            'estado' => $request->estado,
        ]);
    
        foreach ($request->productos as $producto) {
            // Attach al modelo pivot
            if ($producto['cantidad'] !== null) {
                EnvioProducto::create([
                    'envio_id' => $envio->id,
                    'producto_id' => $producto['id'],
                    'cantidad' => $producto['cantidad'],
                ]);
            }}
        return redirect()->route('envios.index');
    }

    public function edit($id)
    {
        $envio = Envio::with('cliente', 'almacen')->find($id);
        $clientes = Cliente::all();
        $almacenes = Almacen::all();
        $productos = Producto::all();
        $usuarios= User::all();

        return view('envios.edit', compact('envio', 'clientes', 'almacenes','productos','usuarios'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cliente_id' => 'required',
            'almacen_id' => 'required',
            'user_id' => 'required',
            'fecha_entrega' => 'required|date',
            'productos' => 'required|array|min:1',
        ]);
    
        // Encuentra el envío que deseas actualizar
        $envio = Envio::findOrFail($id);
    
        // Actualiza los campos del envío
        $envio->update([
            'cliente_id' => $request->cliente_id,
            'almacen_id' => $request->almacen_id,
            'user_id' => $request->user_id,
            'fecha_entrega' => $request->fecha_entrega,
            'detalles' => $request->detalles,
            'estado' => $request->estado,
        ]);
    
        // Elimina los productos asociados al envío
        $envio->productos()->detach();
    
        // Adjunta los nuevos productos al envío
        foreach ($request->productos as $producto) {
            if ($producto['cantidad'] !== null) {
                $envio->productos()->attach($producto['id'], ['cantidad' => $producto['cantidad']]);
            }
        }
    
        return redirect()->route('envios.index');
    }

    public function destroy($id)
    {
        $envio = Envio::find($id);
        $envio->delete();

        return redirect()->route('envios.index');
    }
}
