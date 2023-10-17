@extends('layouts.crud')

@section('content')
    <div class="container">
        <br>
        <h1>Lista de Productos</h1>
        <br>
        <a href="{{ route('home') }}" class="btn btn-primary">inicio</a>
        <a href="{{ route('productos.create') }}" class="btn btn-primary">Agregar Producto</a>
        <br>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock en Almacén</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>{{ $producto->precio }}</td>
                        <td>
                            @foreach ($producto->stocks as $stock)
                                {{ $stock->almacen->nombre }}: {{ $stock->cantidad }}<br>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('productos.destroy', $producto->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Borrar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
