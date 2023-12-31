<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlmacenesController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\EnviosController;
use App\Http\Controllers\AlmacenProductoController;
use App\Http\Controllers\RutaController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('users',UserController::class);
Route::resource('almacenes',AlmacenesController::class);
Route::resource('productos',ProductosController::class);
Route::resource('clientes', ClientesController::class);
Route::resource('envios',EnviosController::class);
Route::resource('almacenes.productos', AlmacenProductoController::class);

Route::resource('envios.rutas', RutaController::class);


// En web.php
Route::get('/seleccionar-rutas', [RutasController::class, 'seleccionarRutas']);
Route::post('/calcular-rutas', [RutasController::class, 'calcularRutaOpenRouteService']);
