<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\Cliente;
use App\Models\DetallePedido;
use App\Models\Producto;

class PedidosController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::all();
        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('pedidos.create', compact('clientes', 'productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_pedido' => 'required|date',
            'productos' => 'array|required',
            'cantidad' => 'required|array', // Asegura que 'cantidad' sea un array
        ]);

        try {
            $pedido = Pedido::create([
                'cliente_id' => $request->input('cliente_id'),
                'fecha_pedido' => $request->input('fecha_pedido'),
            ]);

            $productosSeleccionados = $request->input('productos');
            $cantidades = $request->input('cantidad');

            foreach ($productosSeleccionados as $productoId) {
                DetallePedido::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $productoId,
                    'cantidad' => $cantidades[$productoId],
                ]);
            }

            return redirect()->route('pedidos.index')->with('success', 'Pedido creado exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $pedido = Pedido::find($id);
        $clientes = Cliente::all();
        $productos = Producto::all();
        $productosSeleccionados = $pedido->detalles->pluck('producto_id')->toArray();
        $cantidades = $pedido->detalles->pluck('cantidad', 'producto_id')->toArray();

        return view('pedidos.edit', compact('pedido', 'clientes', 'productos', 'productosSeleccionados', 'cantidades'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_pedido' => 'required|date',
            'productos' => 'array|required',
            'cantidad' => 'required|array', // Asegura que 'cantidad' sea un array
        ]);

        try {
            $pedido = Pedido::find($id);

            if (!$pedido) {
                return back()->with('error', 'Pedido no encontrado');
            }

            $pedido->update([
                'cliente_id' => $request->input('cliente_id'),
                'fecha_pedido' => $request->input('fecha_pedido'),
            ]);

            $productosSeleccionados = $request->input('productos');
            $cantidades = $request->input('cantidad');

            // Actualiza los detalles del pedido
            foreach ($productosSeleccionados as $productoId) {
                if (isset($cantidades[$productoId])) {
                    $detalle = DetallePedido::where('pedido_id', $pedido->id)
                        ->where('producto_id', $productoId)
                        ->first();

                    if ($detalle) {
                        $detalle->update(['cantidad' => $cantidades[$productoId]]);
                    }
                }
            }

            return redirect()->route('pedidos.index')->with('success', 'Pedido actualizado exitosamente');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
{
    $pedido = Pedido::find($id);
    
    if ($pedido) {
        // Elimina los detalles del pedido
        $pedido->detalles()->delete();
    
        // Elimina el pedido
        $pedido->delete();
        
        return redirect()->route('pedidos.index')->with('success', 'Pedido y detalles eliminados exitosamente');
    }
    
    return redirect()->route('pedidos.index')->with('error', 'Pedido no encontrado');
}

}

