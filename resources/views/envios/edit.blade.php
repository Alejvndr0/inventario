
@extends('layouts.crud')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                @if (isset($envio))
                    <div class="card-header">Editar envio N°:{{$envio->id}}</div>
                @else
                    <div class="card-header">Crear envio</div>
                @endif
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (isset($envio))
                        <form method="POST" action="{{url('envios/'.$envio->id)}}">
                    @else
                        <form method="POST" action="{{url('envios')}}">
                    @endif
                        @if(isset($envio))
                            @method('PUT')
                        @endif
                        @csrf
                        @if(isset($envio))
                            <div class="form-group">
                                <label for="estado">Estado:</label>
                                <input type="text" name="estado" class="form-control">
                                <select name="estado" class="form-control">
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="En envio">En envio</option>
                                    <option value="Entregado">Entregado</option>
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="estado" value="Pendiente">
                        @endif
                        <div class="form-group">
                            <label for="almacen_id">Almacén:</label>
                            <select name="almacen_id" class="form-control">
                                @foreach($almacenes as $almacen)
                                    <option value="{{ $almacen->id }}">{{ $almacen->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cliente_id">Cliente:</label>
                            <select name="cliente_id" class="form-control">
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="user_id">Repartidor:</label>
                            <select name="user_id" class="form-control">
                                @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}">{{ $usuario->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fecha_entrega">Fecha de entrega:</label>
                            <input type="date" name="fecha_entrega" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="detalles">Detalles:</label>
                            <textarea class="form-control" id="detalles" name="detalles" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="productos">Productos:</label>
                            @foreach($productos as $producto)
                                <div class="mb-3">
                                    <label for="producto_{{ $producto->id }}">{{ $producto->nombre }}</label>
                                    <input type="number" name="productos[{{ $producto->id }}][cantidad]" class="form-control" min="1">
                                    <input type="hidden" name="productos[{{ $producto->id }}][id]" value="{{ $producto->id }}">
                                </div>
                            @endforeach
                        </div>
                        
                        @if (isset($envio))
                            <div id="map" style="height: 400px;"></div>
                            <input type="hidden" name="ruta" id="ruta" value="{{ $envio->ruta ?? '' }}">
                        @endif
                        @if (isset($envio))
                            <div>
                                <!--<input type="submit" name="botonsito" value="Editar">-->
                                <button type="submit" class="btn btn-success" name="botonsito">Editar</button>
                            </div>
                        @else
                            <div>
                                <button type="submit" class="btn btn-success" name="botonsito">Crear</button>
                            </div>
                        @endif
                        @csrf
                    </form>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
