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
            <br>
            <a href="{{ route('productos.index') }}" class="btn btn-primary">volver</a>
            <button type="submit" class="btn btn-primary">Crear Producto</button>
        </form>
        <br>
    </div>
@endsection
