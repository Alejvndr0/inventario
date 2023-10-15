@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline">Menu</span>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                        <a href="{{ route('almacenes.index') }}" class="btn btn-primary">almacenes</a>
                    
                    </li>
                    <br>
                    <li>
                        <a href="{{ route('clientes.index') }}" class="btn btn-primary">clientes</a>
                    
                    </li>
                    <br>
                    <li>
                        <a href="{{ route('productos.index') }}" class="btn btn-primary">productos</a>
                    </li>
                    <br>
                    <li>
                        <a href="{{ route('pedidos.index') }}" class="btn btn-primary">pedidos</a>
                    </li>
                    
                </ul>
                <hr>
            </div>
        </div>
    </div>
</div>


@endsection
