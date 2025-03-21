<?php

use App\Http\Controllers\Api\EmailController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductInventoryController;
use App\Http\Controllers\Api\RawMaterialController;
use App\Http\Controllers\Api\RawMaterialInventoryController;
use App\Http\Controllers\Api\UseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PharIo\Manifest\Email;


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

//llamar a la ruta
/*
Route:: controller(ProductController::class)->group(function(){
    Route::get('/products','index');
    Route::post('/products','store');
    Route::get('/product/{id}','show');
    Route::put('/product/{id}','update');
    Route::delete('/product/{id}','destroy');

});
*/

Route::apiResource('productInventory', ProductInventoryController::class);
Route::apiResource('rawMaterialInventory', RawMaterialInventoryController::class);
Route::apiResource('product', ProductController::class);
//Route::apiResource('rawMaterial',RawMaterialController::class);
//api para cambiar el valor del identificador de la materia prima dependiendo de que producccion es


{/* */
}
Route::controller(RawMaterialController::class)->group(function () {
    Route::post('rawMaterial', 'store');
    Route::get('/rawMaterials', 'index');
    Route::put('/rawMaterial/identificadorP', [RawMaterialController::class, 'updateIdentificadorP']);
});


Route::controller(UseController::class)->group(function () {
    Route::get('/users', 'index');
    Route::post('/user', 'store');
    Route::get('/user/{id}', 'show');
    Route::put('/user/{id}', 'update');
    Route::delete('/user/{id}', 'destroy');
    Route::post('/user/login', [UseController::class, 'login']);
});

//El usuario debe de estar autenticado para cerrar sesion
Route::middleware('auth:sanctum')->post('/logout', [UseController::class, 'logout']);




Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index');
    Route::post('/products', [ProductController::class, 'storeMultiple']);
    Route::get('/product/{id}', 'show');
    Route::put('/product/{id}', 'update');
    Route::delete('/product/{id}', 'destroy');
});


//Controlador para enviar un correo electronico
Route::post('/email', [EmailController::class, 'enviarCorreo']);

//Controlador para actualizar el correo
Route::post('/update-pass',action:[EmailController::class,'updatePassword']);

