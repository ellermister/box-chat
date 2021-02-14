<?php

namespace App\Providers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Longman\TelegramBot\Telegram;

class TelegramServiceProvinder extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Create Telegram API object
        $this->app->singleton(Telegram::class, function ($app) {
            $bot_api_key = env('BOT_API_KEY');
            $bot_username = env('BOT_USERNAME');
            $telegram = new Telegram($bot_api_key, $bot_username);
            $telegram->setDownloadPath(storage_path('app/public/telegram/download'));
            $telegram->setUploadPath(storage_path('app/public/telegram/upload'));
            return $telegram;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
