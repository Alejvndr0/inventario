@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Pedido</h1>
        <form method="POST" action="{{ route('pedidos.update', $pedido->id) }}">
            @csrf
            @method('PUT') <!-- Utiliza el método HTTP PUT para actualizar el pedido -->

            <div class="form-group">
                <label for="cliente_id">Cliente:</label>
                <select name="cliente_id" id="cliente_id" class="form-control" required>
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}" @if($cliente->id == $pedido->cliente_id) selected @endif>{{ $cliente->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_pedido">Fecha de Pedido:</label>
                <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control" required value="{{ $pedido->fecha_pedido }}">
            </div>
            <div class="form-group">
                <label for="productos[]">Selecciona producto:</label>
                <select name="productos[]" id="productos" class="form-control" multiple required>
                    @foreach ($productos as $producto)
                        <option value="{{ $producto->id }}" @if(in_array($producto->id, $productosSeleccionados)) selected @endif>{{ $producto->nombre }}</option>
                    @endforeach
                </select>
            </div>
            @foreach ($productos as $producto)
                <div class="form-group">
                    <label for="cantidad[{{ $producto->id }}]">Cantidad de {{ $producto->nombre }}</label>
                    <input type="number" id="cantidad[{{ $producto->id }}]" name="cantidad[{{ $producto->id }}]" class="form-control" required step="1" value="{{ $cantidades[$producto->id] }}">
                </div>
            @endforeach
            <button type="submit" class="btn btn-primary">Actualizar Pedido</button>
        </form>
    </div>
@endsection
