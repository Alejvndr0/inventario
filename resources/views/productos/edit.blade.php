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
            <div class="form-group">
                <label for="almacenes">Selecciona almacenes:</label>
                <select name="almacenes[]" id="almacenes" class="form-control" multiple required>
                    @foreach ($almacenes as $almacen)
                        @php
                            $selected = is_array($producto->stocks) ? in_array($almacen->id, $producto->stocks->pluck('almacen_id')->toArray()) : false;
                        @endphp
                        <option value="{{ $almacen->id }}" @if($selected) selected @endif>{{ $almacen->nombre }}</option>
                    @endforeach
                </select>
            </div>
            @foreach ($almacenes as $almacen)
                <div class="form-group">
                    <label for="cantidad_{{ $almacen->id }}">Cantidad en {{ $almacen->nombre }}</label>
                    <input type="number" id="cantidad_{{ $almacen->id }}" name="cantidad[{{ $almacen->id }}]" class="form-control" value="{{ is_array($producto->stocks) ? $producto->stocks->where('almacen_id', $almacen->id)->first()->cantidad : 0 }}">
                </div>
            @endforeach
            <button type="submit" class="btn btn-primary">Actualizar Producto</button>
        </form>
    </div>
</div>
