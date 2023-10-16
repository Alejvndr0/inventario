@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Pedido</h1>
    <form method="POST" action="{{ route('pedidos.store') }}">
        @csrf
        <div class="form-group">
            <label for="cliente_id">Selecciona cliente:</label>
            <select name="cliente_id" id="cliente_id" class="form-control" required>
                @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="fecha_pedido">Fecha del Pedido:</label>
            <input type="date" name="fecha_pedido" id="fecha_pedido" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="productos">Selecciona productos:</label>
            <select name="productos[]" id="productos" class="form-control" multiple required>
                @foreach ($productos as $producto)
                <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                @endforeach
            </select>
        </div>
        @foreach ($productos as $producto)
<div class="form-group">
    <label for="cantidad[{{ $producto->id }}]">Cantidad de {{ $producto->nombre }}</label>
    <input type="number" id="cantidad[{{ $producto->id }}]" name="cantidad[{{ $producto->id }}]" class="form-control" required step="1">
</div>
@endforeach

        <button type="submit" class="btn btn-primary">Crear Pedido</button>
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
@endsection
