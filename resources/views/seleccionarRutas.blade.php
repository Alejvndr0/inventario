<!-- En seleccionarRutas.blade.php -->
@extends('layouts.crud')

@section('content')
    <form method="post" action="/calcular-rutas">
        @csrf
        <label for="almacen">Selecciona un almacén:</label>
        <select name="almacen" id="almacen">
            @foreach ($almacenes as $almacen)
                <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
            @endforeach
        </select>

        <label for="cliente">Selecciona un cliente:</label>
        <select name="cliente" id="cliente">
            @foreach ($clientes as $cliente)
                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
            @endforeach
        </select>

        <button type="submit">Calcular Ruta</button>
    </form>
@endsection
