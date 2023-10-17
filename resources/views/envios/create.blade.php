@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Crear Envio</h1>
        <form method="POST" action="{{ route('envios.store')}}">
            @csrf
            <div class="form-group">
                <label for="cliente_id">Cliente</label>
                <select name="cliente_id" id="cliente_id" class="form-control">
                    @foreach ($clientes as $cliente)
                        <option value="{{ $cliente->id }}" >{{ $cliente->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="almacen_id">Almacén</label>
                <select name="almacen_id" id="almacen_id" class="form-control">
                    @foreach ($almacenes as $almacen)
                        <option value="{{ $almacen->id }}" >{{ $almacen->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="fecha_entrega">Fecha de la entrega</label>
                <input type="date" id="fecha_entrega" name="fecha_entrega" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Crear Envío</button>
        </form>
    </div>
@endsection
