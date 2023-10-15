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
            'cantidad' => 'array|required',
        ]);

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

        return redirect()->route('pedidos.index');
    }

    public function edit($id)
    {
        $pedido = Pedido::find($id);
        $clientes = Cliente::all();
        $productos = Producto::all();
        return view('pedidos.edit', compact('pedido', 'clientes', 'productos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_pedido' => 'required|date',
            'productos' => 'array|required',
            'cantidad' => 'array|required',
        ]);

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

        return redirect()->route('pedidos.index');
    }

    public function destroy($id)
    {
        $pedido = Pedido::find($id);
    
        if ($pedido) {
            // Elimina los detalles del pedido
            $pedido->DetallePedido()->delete();
    
            // Elimina el pedido
            $pedido->delete();
        }
    
        return redirect()->route('pedidos.index');
    }
    
}
