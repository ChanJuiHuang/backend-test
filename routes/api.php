<?php

use App\Http\Controllers\TodoController;
use App\Http\Controllers\TokenController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('accessToken', [TokenController::class, 'createAccessToken']);

Route::prefix('todo')
    ->group(function () {
        Route::post('/', [TodoController::class, 'create']);
        Route::get('/', [TodoController::class, 'search']);
        Route::get('/{id}', [TodoController::class, 'find']);
        Route::patch('/{id}', [TodoController::class, 'update']);
        Route::delete('/', [TodoController::class, 'delete']);
    });
