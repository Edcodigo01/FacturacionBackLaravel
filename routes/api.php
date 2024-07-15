<?php

use App\Http\Controllers\AuthController;

use App\Http\Controllers\inventario\AlmacenController;
use App\Http\Controllers\inventario\CategoriaController;
use App\Http\Controllers\inventario\PreciosAddProductosController;
use App\Http\Controllers\inventario\ProductoController;
use App\Http\Controllers\users\ClienteController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', [AuthController::class, 'login']);

Route::get('prueba', function(){
    return "X";
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('comercio')->group(function () {
        Route::resource('ventas', VentaController::class);
        // Route::controller(VentaController::class)->group(function () {
        //     Route::get("ventas/{id?}", 'index');
        // });
    });
    // CLIENTES
    Route::resource('clientes', ClienteController::class);
    Route::controller(ClienteController::class)->group(function () {
        Route::delete('clientes-deshabilitar/{id}', 'disabled');
        Route::post("clientes-habilitar-eliminar-lote", 'habilitar_eliminar_lote');
    });
    // INVENTARIO
    Route::prefix('inventario')->group(function () {
        // ALMACENES
        Route::resource('almacenes', AlmacenController::class);
        Route::controller(AlmacenController::class)->group(function () {
            Route::delete('almacenes-deshabilitar/{id}', 'disabled');
            Route::post("almacenes-habilitar-eliminar-lote", 'habilitar_eliminar_lote');
        });
        // CATEGORIAS
        Route::resource('categorias', CategoriaController::class);
        Route::controller(CategoriaController::class)->group(function () {
            Route::delete('categorias-deshabilitar/{id}', 'disabled');
            Route::post("categorias-habilitar-eliminar-lote", 'habilitar_eliminar_lote');
        });
        // PRODUCTOS
        Route::resource('productos', ProductoController::class);
        Route::resource('precios-adicionales-productos', PreciosAddProductosController::class);
        Route::controller(ProductoController::class)->group(function () {
            Route::delete('productos-deshabilitar/{id}', 'disabled');
            Route::post("productos-habilitar-eliminar-lote", 'habilitar_eliminar_lote');
            Route::get("productos-recursos", 'recursos');
        });
    });
    // Route::delete('clientes-deshabilitar/{id}', [ClienteController::class,'disabled']);
    // Route::post('clientes-habilitar-eliminar-lote', [ClienteController::class,'habilitar_eliminar_lote']);
});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
