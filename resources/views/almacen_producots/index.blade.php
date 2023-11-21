@extends('layouts.crud')

@section('content')
    <div>
    @if(session('warning'))
        <div class="alert alert-warning">
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button
        </div>
    @endif
    </div>
    <div class="container">
        <br>
        <h1>Lista de Productos - Almacen: {{$almacen->nombre}} </h1>
        <br>
        <a href="{{ route('home') }}" class="btn btn-primary">inicio</a>
        <a href="{{ url('almacenes/'.$almacen->id.'/productos/create') }}" class="btn btn-primary">Agregar Producto</a>
        <br>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productosEnAlmacen as $producto)
                    <tr>
                        <td>{{ $producto->id }}</td>
                        <td>{{ $producto->nombre }}</td>
                        <td>{{ $producto->descripcion }}</td>
                        <td>{{ $producto->precio }}</td>
                        <td>{{$producto->cantidad}}
                            @foreach ($producto->stocks as $stock)
                            {{ $stock->cantidad }}<br>
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ url('almacenes/'.$almacen->id.'/productos/'.$producto->id.'/edit') }}" class="btn btn-warning">Editar</a>
                            <form action="{{ url('almacenes/'.$almacen->id.'/productos/'.$producto->id) }}" method="POST" style="display: inline;">
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
