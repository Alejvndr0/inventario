@extends('layouts.crud')

@section('content')
    <div class="container">
        <br>
        <h1>Crear Producto</h1>
        <form method="POST" action="{{ route('productos.store') }}">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre del Producto</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="precio">Precio</label>
                <input type="text" id="precio" name="precio" class="form-control" required>
            </div>

            <!-- Campo "almacenes" como selección múltiple -->
            <div class="form-group">
                <label for="almacenes">Selecciona los almacenes:</label>
                <select name="almacenes[]" id="almacenes" class="form-control" multiple required>
                    @foreach ($almacenes as $almacen)
                        <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Agregar campos para la cantidad de stock en almacén -->
            @foreach ($almacenes as $almacen)
                <div class="form-group">
                    <label for="cantidad_{{ $almacen->id }}">Stock en {{ $almacen->nombre }}</label>
                    <input type="number" id="cantidad_{{ $almacen->id }}" name="cantidad_{{ $almacen->id }}"
                        class="form-control" value="0">
                </div>
            @endforeach
            <br>
            <a href="{{ route('productos.index') }}" class="btn btn-primary">volver</a>
            <button type="submit" class="btn btn-primary">Crear Producto</button>
        </form>
        <br>
    </div>
@endsection
