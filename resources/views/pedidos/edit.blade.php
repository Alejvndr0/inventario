@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Pedido</h1>
    <form method="POST" action="{{ route('pedidos.update', $pedido->id) }}">
        @csrf
        @method('PUT')

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
            <label for="productos">Selecciona productos:</label>
            <select name="productos[]" id="productos" class="form-control" multiple required>
                @foreach ($stockProductos as $producto)
                    <option value="{{ $producto->id }}">
                        {{ $producto->nombre }} (Stock: {{ $producto->stocks->sum('cantidad') }})
                    </option>
                @endforeach
            </select>
        </div>
        @foreach ($productos as $producto)
        <div class="form-group">
            <label for="cantidad[{{ $producto->id }}]">Cantidad de {{ $producto->nombre }}</label>
            @php
                $detalleProducto = $pedido->detalles->where('producto_id', $producto->id)->first();
            @endphp
            <input type="number" id="cantidad[{{ $producto->id }}]" name="cantidad[{{ $producto->id }}]" class="form-control" max="{{ $producto->stocks->sum('cantidad') }}" value="{{ $detalleProducto ? $detalleProducto->cantidad : 0 }}">
        </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Actualizar Pedido</button>
    </form>
</div>
@if ($errors->any())
<div class="container">
    <div class="alert alert-danger mt-4">
        <h5>Errores de validación:</h5>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif
</div>
@endsection
