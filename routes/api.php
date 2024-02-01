<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProductosFacturaController;
use App\Http\Controllers\RecordatorioController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ENDPOINTS USUARIO
Route::controller(UsuarioController::class)->prefix('usuarios')-> group(function () {
    Route::post('/new', 'create');
    Route::get('/login', 'login');
    Route::get('/{id}', 'getById');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});

// ENDPOINTS CLIENTES
Route::controller(ClienteController::class)->prefix('clientes')-> group(function () {
    Route::get('/usuario/{id_usuario}', 'getAllByIdUsuario');
    Route::get('/{id}', 'getById');
    Route::post('/new', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});

// ENDPOINTS FACTURAS
Route::controller(FacturaController::class)->prefix('facturas')-> group(function () {
    Route::get('/emisor/{id_usuario}', 'getAllByIdEmisor');
    Route::get('/receptor/{id_usuario}', 'getAllByIdReceptor');
    Route::get('/{id}', 'getById');
    Route::post('/new', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});

// ENDPOINTS PRODUCTOS
Route::controller(ProductoController::class)->prefix('productos')-> group(function () {
    Route::get('/usuario/{id_usuario}', 'getAllByIdUsuario');
    Route::get('/{id}', 'getById');
    Route::post('/new', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});

// ENDPOINTS RECORDATORIOS
Route::controller(RecordatorioController::class)->prefix('recordatorios')-> group(function () {
    Route::get('/usuario/{id_usuario}', 'getAllByIdUsuario');
    Route::get('/{id}', 'getById');
    Route::post('/new', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});

// ENDPOINTS PRODUCTOS FACTURAS
Route::controller(ProductosFacturaController::class)->prefix('productos_facturas')-> group(function () {
    Route::get('/factura_id/{id_factura}', 'getAllByIdFactura');
    Route::get('/{id}', 'getById');
    Route::post('/new', 'create');
    Route::put('/{id}', 'update');
    Route::delete('/{id}', 'delete');
});
