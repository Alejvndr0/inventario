@extends('layouts.app')

@section('content')
<style>

    .nav-pills li a:hover {
        color: black !important; 
        background-color: white; 
    }
</style>
<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="bg-dark col-auto col-md-4 col-lg-3 min-vh-100">
            <div class="bg-dark p-2">
                <a href="/" class="d-flex align-items-center mt-1 text-white text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline">Menu</span>
                </a>
                <ul class="nav nav-pills flex-column mt-4" id="menu">
                    <li class="nav-item">
                        <a href="{{ route('almacenes.index') }}" class="nav-link text-white"><span class="fs-5 d-none d-sm-inline">Almacenes</span></a>
                    
                    </li>
                    <br>
                    <li class="nav-item">
                        <a href="{{ route('clientes.index') }}" class="nav-link text-white"><span class="fs-5 d-none d-sm-inline">Clientes</span></a>
                    
                    </li>
                    <br>
                    <li class="nav-item">
                        <a href="{{ route('productos.index') }}" class="nav-link text-white"><span class="fs-5 d-none d-sm-inline">Productos</span></a>
                    </li>
                    <br>
                    <li class="nav-item">
                        <a href="{{ route('envios.index') }}" class="nav-link text-white"><span class="fs-5 d-none d-sm-inline">Envios</span></a>
                    </li>
                    
                </ul>
                <hr>
            </div>
        </div>
    </div>
</div>



@endsection
