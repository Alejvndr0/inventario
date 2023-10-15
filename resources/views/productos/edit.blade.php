@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Producto</h1>
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form method="POST" action="{{ route('productos.update', $producto->id) }}">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nombre">Nombre del Producto</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="{{ $producto->nombre }}" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="form-control" required>{{ $producto->descripcion }}</textarea>
            </div>
            <div class="form-group">
                <label for="precio">Precio</label>
                <input type="text" id="precio" name="precio" class="form-control" value="{{ $producto->precio }}" required>
            </div>
            @foreach ($almacenes as $almacen)
                <div class="form-group">
                    <label for="cantidad_{{ $almacen->id }}">Stock en {{ $almacen->nombre }}</label>
                    @if ($producto->stockEnAlmacenes)
                        @php
                            $stockEnAlmacen = $producto->stockEnAlmacenes->where('almacen_id', $almacen->id)->first();
                        @endphp
                        <input type="number" id="cantidad_{{ $almacen->id }}" name="cantidad_{{ $almacen->id }}" class="form-control" value="{{ $stockEnAlmacen ? $stockEnAlmacen->cantidad : 0 }}">
                    @else
                        <input type="number" id="cantidad_{{ $almacen->id }}" name="cantidad_{{ $almacen->id }}" class="form-control" value="0">
                    @endif
                </div>
            @endforeach
            <button type="submit" class="btn btn-primary">Actualizar Producto</button>
        </form>
    </div>
</div>
