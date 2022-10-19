<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\LoginUser;
use App\Http\Controllers\User\StoreUser;
use App\Http\Controllers\User\ShowUser;
use App\Http\Controllers\Thread\IndexThread;
use App\Http\Controllers\Thread\StoreThread;
use App\Http\Controllers\Thread\ShowThread;
use App\Http\Controllers\Message\IndexMessage;
use App\Http\Controllers\Message\StoreMessage;
use App\Http\Controllers\Message\UpdateMessage;

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


Route::group(['middleware' => 'guest'], function() {
    Route::post('/user', [
        'uses' => StoreUser::class
    ]);

    Route::post('/login', [
        'uses' => LoginUser::class
    ]);
});

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/user/{id}', [
        'uses' => ShowUser::class
    ]);

    Route::post('/thread', [
        'uses' => StoreThread::class
    ]);

    Route::get('/thread', [
        'uses' => IndexThread::class
    ]);

    Route::get('/thread/{id}', [
        'uses' => ShowThread::class
    ]);

    Route::post('/message', [
        'uses' => StoreMessage::class
    ]);

    Route::put('/message/{id}', [
        'uses' =>UpdateMessage::class
    ]);

    Route::get('/message', [
        'uses' => IndexMessage::class
    ]);
});
