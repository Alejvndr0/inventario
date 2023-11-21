@extends('layouts.crud')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                    @if(isset($producto))
                    <div class="card-header" >{{ $almacen->nombre }} - Editar cantidad {{ $producto->nombre }}</div>
                    <form action="{{ url('almacenes/'.$almacen->id.'/productos/'.$producto->id) }}" method="POST">
                    @else
                    <div class="card-header" >{{ $almacen->nombre }} - Añadir Producto</div>
                    <form action="{{ url('almacenes/'.$almacen->id.'/productos') }}" method="POST">

                    @endif
                    <div class="card-body" >

                        @if(isset($producto))
                            @method('PUT')
                        @endif
                        @csrf
                        @if(empty($producto))
                            <div class="form-group">
                                <label for="productos[]">Seleccionar producto:</label>
                                <select name="productos[]" id="productos" class="form-control" >
                                    @foreach ($productos as $product)
                                        <option value="{{ $product->id }}">{{ $product->nombre }}</option>
                                    @endforeach
                                </select>
                            </div><br>
                        @endif
                        <div class="form-group">
                            <label for="cantidad">Cantidad:</label>
                            <input type="number" name="cantidad" id="cantidad" required>
                        </div>
                        <br>
                        @if(isset($producto))
                            <button type="submit" class="btn btn-primary" >Editar</button>
                        @else
                            <button type="submit" class="btn btn-primary" >Crear</button>
                        @endif
                        <a href="{{ url('almacenes/'.$almacen->id.'/productos') }}" class="btn btn-primary" >Atras</a>
                    </div>
                    </form>
            </div>
        </div>
    </div>
</div>
@endsection