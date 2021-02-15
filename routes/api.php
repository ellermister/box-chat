<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/room/profile', [\App\Http\Controllers\RoomController::class, 'getRoomProfile']);

// 聊天室访客相关接口
// >> 获取用户ID
// >> 发送消息
// >> 拉取消息
// >> 上传图片
Route::post('/room/set_user', [\App\Http\Controllers\RoomController::class, 'setUserName']);
Route::post('/room/message/new', [\App\Http\Controllers\RoomController::class, 'sendMessage']);
Route::get('/room/message', [\App\Http\Controllers\RoomController::class, 'getMessages']);

// 聊天室Bot回调接口
Route::get('/bot/set_hook', [\App\Http\Controllers\BotHookController::class, 'setHook']);
Route::match(['get','post'],'/bot/hook', [\App\Http\Controllers\BotHookController::class, 'hookHandle']);
