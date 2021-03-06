<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\App;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group(['prefix' => '{language}'], function () {
    Route::post('/login',[AuthController::class,'login']);
});

    Route::post('/login',[AuthController::class,'login']);

    Route::group(['middleware' => 'auth:sanctum'], function (){
        Route::get('/user',function(Request $request){
            return $request->user();
        });
        Route::resource('empresa',EmpresaController::class);
        Route::resource('empleado',EmpleadoController::class);
    });
// });
