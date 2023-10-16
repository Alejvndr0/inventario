<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\Producto;
use App\Models\StockEnAlmacen;
use App\Models\Cliente;

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
    $stockProductos = Producto::with('stocks')->get();

    return view('pedidos.create', compact('clientes', 'productos', 'stockProductos'));
}

public function store(Request $request)
{
    $request->validate([
        'cliente_id' => 'required|exists:clientes,id',
        'fecha_pedido' => 'required|date',
        'productos' => 'array|required',
        'cantidad' => 'array|required',
    ]);

    try {
        $pedido = Pedido::create([
            'cliente_id' => $request->input('cliente_id'),
            'fecha_pedido' => $request->input('fecha_pedido'),
        ]);

        $productosSeleccionados = $request->input('productos');
        $cantidades = $request->input('cantidad');

        foreach ($productosSeleccionados as $productoId) {
            $producto = Producto::find($productoId);

            if ($producto) {
                $cantidadSolicitada = $cantidades[$productoId];
                $stockProducto = StockEnAlmacen::where('producto_id', $productoId)->first();

                if ($cantidadSolicitada <= $stockProducto->cantidad) {
                    DetallePedido::create([
                        'pedido_id' => $pedido->id,
                        'producto_id' => $productoId,
                        'cantidad' => $cantidadSolicitada,
                    ]);

                    // Actualizar el stock en el almacén
                    $stockProducto->decrement('cantidad', $cantidadSolicitada);
                } else {
                    return back()->with('error', 'No hay suficiente stock para el producto ' . $producto->nombre);
                }
            } else {
                return back()->with('error', 'Producto no encontrado');
            }
        }

        return redirect()->route('pedidos.index')->with('success', 'Pedido creado exitosamente');
    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }
}

public function edit($id)
{
    $pedido = Pedido::findOrFail($id);
    $clientes = Cliente::all();
    $productos = Producto::all();
    $stockProductos = Producto::with('stocks')->get();

    return view('pedidos.edit', compact('pedido', 'clientes', 'productos', 'stockProductos'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'cliente_id' => 'required|exists:clientes,id',
        'fecha_pedido' => 'required|date',
        'productos' => 'array|required',
        'cantidad' => 'array|required',
    ]);

    try {
        $pedido = Pedido::find($id);

        if (!$pedido) {
            return back()->with('error', 'Pedido no encontrado');
        }

        // Recuperar los detalles actuales del pedido
        $detallesActuales = $pedido->detalles;

        // Revertir la cantidad utilizada en el stock correspondiente para los detalles actuales
        foreach ($detallesActuales as $detalle) {
            $stockProducto = StockEnAlmacen::where('producto_id', $detalle->producto_id)->first();
            $stockProducto->increment('cantidad', $detalle->cantidad);
        }

        // Eliminar los detalles actuales del pedido
        $detallesActuales->each->delete();

        $productosSeleccionados = $request->input('productos');
        $cantidades = $request->input('cantidad');

        foreach ($productosSeleccionados as $productoId) {
            $producto = Producto::find($productoId);

            if ($producto) {
                $cantidadSolicitada = $cantidades[$productoId];
                $stockProducto = StockEnAlmacen::where('producto_id', $productoId)->first();

                if ($cantidadSolicitada <= $stockProducto->cantidad) {
                    DetallePedido::create([
                        'pedido_id' => $pedido->id,
                        'producto_id' => $productoId,
                        'cantidad' => $cantidadSolicitada,
                    ]);

                    // Actualizar el stock en el almacén
                    $stockProducto->decrement('cantidad', $cantidadSolicitada);
                } else {
                    return back()->with('error', 'No hay suficiente stock para el producto ' . $producto->nombre);
                }
            } else {
                return back()->with('error', 'Producto no encontrado');
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
        // Recupera los detalles del pedido
        $detalles = $pedido->detalles;

        // Revierte la cantidad utilizada en el stock correspondiente
        foreach ($detalles as $detalle) {
            $stockProducto = StockEnAlmacen::where('producto_id', $detalle->producto_id)->first();
            $stockProducto->increment('cantidad', $detalle->cantidad);
        }

        // Elimina los detalles del pedido
        $pedido->detalles()->delete();

        // Elimina el pedido
        $pedido->delete();

        return redirect()->route('pedidos.index')->with('success', 'Pedido y detalles eliminados exitosamente');
    }

    return redirect()->route('pedidos.index')->with('error', 'Pedido no encontrado');
}

}
