@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Pedido</h1>
        <form method="POST" action="{{ route('pedidos.update', $pedido->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="cliente_id">Cliente</label>
                <select name="cliente_id" id="cliente_id" class="form-control">
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}" @if($cliente->id == $pedido->cliente_id) selected @endif>{{ $cliente->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_pedido">Fecha del Pedido</label>
                <input type="date" id="fecha_pedido" name="fecha_pedido" class="form-control" required value="{{ $pedido->fecha_pedido }}">
            </div>
            <div class="form-group">
                <label for="productos">Selecciona producto:</label>
                <select name="productos[]" id="productos" class="form-control" multiple required>
                    @foreach ($productos as $producto)
                        <option value="{{ $producto->id }}" @if($pedido->detalles->contains('producto_id', $producto->id)) selected @endif>{{ $producto->nombre }}</option>
                    @endforeach
                </select>
            </div>
            @foreach ($productos as $producto)
                <div class="form-group">
                    <label for="cantidad_{{ $producto->id }}">Cantidad del producto {{ $producto->nombre }}</label>
                    <input type="number" id="cantidad_{{ $producto->id }}" name="cantidad[{{ $producto->id }}]" class="form-control" value="{{ optional($pedido->detalles->where('producto_id', $producto->id)->first())->cantidad ?? 0 }}">
                </div>
            @endforeach
            <button type="submit" class="btn btn-primary">Actualizar Pedido</button>
        </form>
    </div>
@endsection
