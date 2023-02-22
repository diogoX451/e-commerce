<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserConroler;
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





Route::post('/login', [UserConroler::class, 'login'])->name('login');
Route::post('/logout', [UserConroler::class, 'logout']);
Route::group([
    'middleware' => 'apiLogin',
], function () {
    Route::get('/users', [UserConroler::class, 'index']);
    Route::post('/users', [UserConroler::class, 'store']);
});
