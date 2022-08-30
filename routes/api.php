<?php
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/usuariosapi', function (Request $request) {
    
    return 'Not aunthenticated';
});
*/
//Route::resource('usuariosapi', UserController::class)->middleware('auth:sanctum');
//Route::resource('usuariosapi', UserController::class);

Route::apiResource('usuariosapi', UserController::class)->middleware('auth:sanctum');

//Route::post('/auth/register',[AuthController::class, 'createUser']);
Route::post('/auth/login',[AuthController::class, 'loginUser']);