<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserConroler;
use Illuminate\Support\Facades\Http;

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





Route::post('/login', [UserConroler::class, 'login']);
Route::post('/teste', [UserConroler::class, 'register']);

Route::group(['prefix' => 'auth'], function () {
});

Route::get('/callback', function (Request $request) {
    $state = $request->session()->pull('state');

    throw_unless(
        strlen($state) > 0 && $state === $request->state,
        InvalidArgumentException::class
    );

    $response = Http::asForm()->post('http://ecommerce.api/api/oauth/token', [
        'grant_type' => 'authorization_code',
        'client_id' => '2',
        'client_secret' => '5ySx3jpXoE2TvrOBKp2kSTrZITsojQxQWbyrD8ym',
        'redirect_uri' => 'http://ecommerce.api/api/users',
        'code' => $request->code,
    ]);

    return $response->json();
});

Route::middleware('auth:api')->get('/user', [UserConroler::class, 'index']);

Route::group([
    'middleware' => 'auth:api',
], function () {
    Route::get('/users',);
    Route::post('/logout', [UserConroler::class, 'logout']);
});
