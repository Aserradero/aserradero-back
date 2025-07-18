<?php

use App\Http\Controllers\Api\CatalogProductController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\EmailController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PriceHistoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductSaleController;
use App\Http\Controllers\Api\ProductInventoryController;
use App\Http\Controllers\Api\ProductionHistoryController;
use App\Http\Controllers\Api\RawMaterialController;
use App\Http\Controllers\Api\RawMaterialInventoryController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\UseController;
use App\Http\Controllers\Api\BillController;
use App\Models\ProductionHistory;
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
Route::apiResource('material', RawMaterialController::class);
Route::apiResource('priceHistory', PriceHistoryController::class);
//Route::apiResource('rawMaterial',RawMaterialController::class);
//api para cambiar el valor del identificador de la materia prima dependiendo de que producccion es
{/* */
}
Route::controller(RawMaterialController::class)->group(function () {
    Route::get('/rawMaterials', 'index');
    Route::post('/rawMaterials', [RawMaterialController::class, 'storeMultiple']);
    Route::put('/rawMaterial/identificadorP', [RawMaterialController::class, 'updateIdentificadorP']);
    Route::put('/rawMaterials/{id}', 'update');
    Route::delete('/rawMaterial/{id}', 'destroy');
    Route::get('/raw-materials/grouped', [RawMaterialController::class, 'getGroupedRawMaterials']);
});


Route::controller(UseController::class)->group(function () {
    Route::get('/users', 'index');
    Route::post('/user', 'store');
    Route::get('/user/{id}', 'show');
    Route::put('/user/{id}', 'update');
    Route::delete('/user/{id}', 'destroy');
    Route::post('/user/login', [UseController::class, 'login']);
    Route::put('/user/updateRegister/{email}', [UseController::class, 'updateRegister']);

});

//El usuario debe de estar autenticado para cerrar sesion
Route::middleware('auth:sanctum')->post('/logout', [UseController::class, 'logout']);
//Route::post('/logout', [UseController::class, 'logout']);


Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index');
    Route::post('/products', [ProductController::class, 'storeMultiple']);
    Route::get('/product/{id}', 'show');
    Route::put('/product/{id}', 'update');
    Route::delete('/product/{id}', 'destroy');
});

Route::controller(ProductSaleController::class)->group(function () {
    Route::get('/productsSale', 'index');
    Route::get('/productSale/{id}', 'show');
});

Route::controller(ProductInventoryController::class)->group(function () {
    Route::get('/productsInventory', 'index');
    Route::post('/productsInventory', [ProductInventoryController::class, 'storeMultiple']);
    Route::get('/productInventory/{id}', 'show');
    Route::put('/productInventory/{id}', 'update');
    Route::put('/productInventoryPrecioStock', [ProductInventoryController::class, 'updatePrecioStock']);
    Route::delete('/productInventory/{id}', 'destroy');
    Route::patch('/productInventoryCantidad/{id}', [ProductInventoryController::class, 'eliminarProductoCantidad']);
});

Route::controller(RawMaterialInventoryController::class)->group(function () {
    Route::get('/rawMaterialsInventory', 'index');
    Route::post('/rawMaterialInventory', [RawMaterialInventoryController::class, 'storeMultiple']);
    Route::get('/rawMaterialInventory/{id}', 'show');
    Route::put('/rawMaterialInventory/{id}', 'update');
    Route::delete('/rawMaterialInventory/{id}', 'destroy');
});

Route::controller(ProductionHistoryController::class)->group(function () {
    Route::post('/productionHistory', [ProductionHistoryController::class, 'storeMultiple']);
    Route::post('/productionHistoryNu', [ProductionHistoryController::class, 'registrarProduccionYActualizarMaterias']);
    Route::get('/obtenerProductionHistory', 'index');
    Route::put('/productionHistory/{id}', 'update');
    Route::put('/productionHistoryUpdate/{id}', [ProductionHistoryController::class, 'updateStatus']);
    Route::put('/productionHistoryDatos', [ProductionHistoryController::class, 'updateDatos']);
});




//Rutas para el catalogo de productos
Route::controller(CatalogProductController::class)->group(function () {
    Route::get('/catalogProduct', 'index');
    Route::post('/catalogProduct', 'store');
    Route::put('/catalogProduct/{id}', action: [CatalogProductController::class, 'update']);
    Route::delete('/catalogProduct/{id}', [CatalogProductController::class, 'destroy']);

});

//Rutas para el historial de precios
Route::controller(PriceHistoryController::class)->group(function () {
    Route::get('/priceHistory', 'index');
    Route::post('/priceHistory', [PriceHistoryController::class, 'store']);
    Route::get('/priceHistory/{id}', 'show');

});


//Controlador para enviar un correo electronico
Route::post('/email', [EmailController::class, 'enviarCorreo']);


//Controlador para actualizar el correo
Route::post('/update-pass', action: [EmailController::class, 'updatePassword']);


//Controlador para mandar el correo
Route::post('/verificarEmail', action: [EmailController::class, 'verificarEmail']);


//controlador para hacer la verificacion 

Route::get('/confirmarEmail', [EmailController::class, 'confirmarEmail']);


Route::post('/verify-email', [EmailController::class, 'verifyEmail']);
Route::get('/verify-email/{token}', [EmailController::class, 'verifyToken']);


Route::middleware(['token.expired'])->group(function () {
    Route::get('/token-user', function (Request $request) {
        return response()->json(['message' => 'Token válido']);
    });
});

//store
Route::post('/ventas', [SaleController::class, 'store']);



// Api para obtener los archivos ppublicos
Route::get('/archivo-publico/{path}', function ($path) {
    $file = public_path('storage/' . $path);

    if (!\File::exists($file)) {
        abort(404);
    }

    return response()->file($file);
})->where('path', '.*');


//rutas para la factura
Route::post('/bills', [BillController::class, 'store']);

//rutas para la obtener las ventas
Route::get('/sales', [SaleController::class, 'index']);

//rutas para establecer los clientes
Route::controller(ClientController::class)->group(function () {

    Route::post('/client', [ClientController::class, 'store']);
    Route::get('/client', [ClientController::class, 'findByRfc']);
    Route::get('/clients', [ClientController::class, 'index']);
    Route::post('/clientes/buscar-rfc', [ClientController::class, 'buscarPorRfc']);
    Route::delete('/client/{id}', [ClientController::class, 'destroy']);
    Route::put('/client/{id}', [ClientController::class, 'update']);
});
