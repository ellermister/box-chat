<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Longman\TelegramBot\Telegram;

class BotHookController extends Controller
{
    public function setHook(Request $request,Telegram $telegram)
    {
        try{
            $hookUrl = env('APP_URL').'/api/bot/hook';
            $result = $telegram->setWebhook($hookUrl);
            if ($result->isOk()) {
                return ee_json($result->getDescription(), 200, $hookUrl);
            }
            return ee_json('呦吼，设置失败~', 500);
        }catch (\Longman\TelegramBot\Exception\TelegramException $e){
            return ee_json($e->getMessage(), 500);
        }
    }

    public function hookHandle(Request $request,Telegram $telegram)
    {
        $result = $telegram->addCommandsPaths([app_path('BotCommands')]);
        // Handle telegram webhook request
        $result = $telegram->handle();
    }
}
