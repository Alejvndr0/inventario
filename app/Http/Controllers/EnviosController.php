<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Envio;
use App\Models\Almacen;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

class EnviosController extends Controller
{
    public function index()
    {
        $envios = Envio::with('cliente', 'almacen')->get();

        return view('envios.index', compact('envios'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $almacenes = Almacen::all();

        return view('envios.create', compact('clientes', 'almacenes'));
    }

    public function store(Request $request)
    {
        $envio = new Envio();
        $envio->cliente_id = $request->input('cliente_id');
        $envio->almacen_id = $request->input('almacen_id');
        $envio->fecha_entrega = $request->input('fecha_entrega');
        $envio->save();

        return redirect()->route('envios.index');
    }

    public function edit($id)
    {
        $envio = Envio::with('cliente', 'almacen')->find($id);
        $clientes = Cliente::all();
        $almacenes = Almacen::all();

        return view('envios.edit', compact('envio', 'clientes', 'almacenes'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'cliente_id' => 'required',
            'almacen_id' => 'required',
            'fecha_entrega' => 'required|date',
            'ruta' => 'required', // Asegúrate de validar la ruta según tus necesidades
        ]);

        // Obtener el envío que deseas actualizar
        $envio = Envio::findOrFail($id);

        // Actualizar los campos del envío
        $envio->cliente_id = $request->input('cliente_id');
        $envio->almacen_id = $request->input('almacen_id');
        $envio->fecha_entrega = $request->input('fecha_entrega');

        // Almacenar la ruta en el formato adecuado (por ejemplo, WKT)
        $ruta = $request->input('ruta');
        // Guardar los cambios
        $envio->ruta = DB::raw("ST_GeomFromText('LINESTRING($ruta)')");
        $envio->save();


        // Resto de la lógica de redirección o respuesta

        return redirect()->route('envios.index')->with('status', 'Envío actualizado correctamente');
    }

    public function destroy($id)
    {
        $envio = Envio::find($id);
        $envio->delete();

        return redirect()->route('envios.index');
    }
}
