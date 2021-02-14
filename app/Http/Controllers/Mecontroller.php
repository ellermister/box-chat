<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Request as TelegramRequest;

class Mecontroller extends Controller
{
    public function showMe(Request $request, Telegram $telegram)
    {
        return response(json_encode(TelegramRequest::getMe(), JSON_UNESCAPED_UNICODE));
    }
}
