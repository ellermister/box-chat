<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/bot/me', [\App\Http\Controllers\Mecontroller::class,'showMe']);
// 提醒消息(只能发给自己) /bot/notify/***
// 代理消息(通过自己的机器人发送消息)  /bot/proxy/***
Route::get('/bot/notify/message', [\App\Http\Controllers\SimpleNotifyController::class,'sendMessage']);

// 聊天室访客页面
Route::get('/room/guest', [\App\Http\Controllers\RoomController::class,'showGuestRoom']);
Route::post('/upload/img', [\App\Http\Controllers\RoomController::class,'uploadImage']);