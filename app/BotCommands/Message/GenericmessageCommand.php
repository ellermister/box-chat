<?php

/**
 * This file is part of the PHP Telegram Bot example-bot package.
 * https://github.com/php-telegram-bot/example-bot/
 *
 * (c) PHP Telegram Bot Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Generic message command
 *
 * Gets executed when any type of message is sent.
 *
 * In this message-related context, we can handle any kind of message.
 */

namespace Longman\TelegramBot\Commands\SystemCommands;
//namespace App\BotCommands\Message;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Longman\TelegramBot\Commands\SystemCommand;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Request;

class GenericmessageCommand extends SystemCommand
{
    /**
     * @var string
     */
    protected $name = 'genericmessage';

    /**
     * @var string
     */
    protected $description = 'Handle generic message';

    /**
     * @var string
     */
    protected $version = '1.0.0';

    /**
     * Main command execution
     *
     * @return ServerResponse
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function execute(): ServerResponse
    {
        $message = $this->getMessage();
        $replyMessage = $message->getReplyToMessage();

        // 回复消息
        $toUserId = 0;
        if ($replyMessage) {
            $replyMessageObj = DB::table('messages')->where('message_id', $replyMessage->getMessageId())->first();
            if ($replyMessageObj) {
                if ($replyMessageObj->from_id == $message->getFrom()->getId()) {
                    $toUserId = $replyMessageObj->to_user_id;
                } else {
                    $toUserId = $replyMessageObj->from_user_id;
                }
            }
        }

        $media_type = 0;
        $media_width = 0;
        $media_height = 0;
        $media = '';

        $message_text = $message->getText();
        $stickerPath = '';

        // 贴图
        if ($message->getSticker() && $message->getSticker()->getEmoji()) {
            $message_text = $message->getSticker()->getEmoji();

            $file = Request::getFile(['file_id' => $message->getSticker()->getFileId()]);
            if ($file->isOk() && $res = Request::downloadFile($file->getResult())) {
                $stickerPath = 'public/telegram/download/' . $file->getResult()->getFilePath();
                $media = $stickerPath;
                $media_type = 3;
                $media_width = $message->getSticker()->getWidth();
                $media_height = $message->getSticker()->getHeight();
//                $StickerSetName = $message->getSticker()->getSetName();
//                $sticker = Request::getStickerSet(['name' => $StickerSetName]);
//                $sticker->getResult()->getStickers();
            }
        }

        // GIF
        if ($animation = $message->getAnimation()) {
            $file = Request::getFile(['file_id' => $message->getAnimation()->getFileId()]);
            if ($file->isOk() && $res = Request::downloadFile($file->getResult())) {
                $mediaPath = 'public/telegram/download/' . $file->getResult()->getFilePath();
                $media = $mediaPath;
                $media_type = 4;
                $media_width = $animation->getWidth();
                $media_height = $animation->getHeight();
            }
        }

        // photo
        if ($photo = $message->getPhoto()) {
            $lastPhotoFile = end($photo);
            $file = Request::getFile(['file_id' => $lastPhotoFile->file_id]);
            if ($file->isOk() && $res = Request::downloadFile($file->getResult())) {
                $mediaPath = 'public/telegram/download/' . $file->getResult()->getFilePath();
                $media = $mediaPath;
                $media_type = 1;
                $media_width = $lastPhotoFile->getWidth();
                $media_height = $lastPhotoFile->getHeight();
            }
        }

        \Illuminate\Support\Facades\DB::table('messages')->insert([
            'from_name'    => $message->getChat()->getFirstName() . $message->getChat()->getLastName(),
            'message_text' => $message_text,
            'sticker_path' => $stickerPath,
            'media'        => $media,
            'media_type'   => $media_type,
            'media_width'  => $media_width,
            'media_height' => $media_height,
            'message_id'   => $message->getMessageId(),
            'chat_id'      => $message->getChat()->getId(),
            'from_id'      => $message->getFrom()->getId(),
            'reply_id'     => $replyMessage ? $replyMessage->getMessageId() : 0,
            'to_user_id'   => $toUserId,
            'created_at'   => time(),
            'updated_at'   => time()
        ]);
        return Request::emptyResponse();
    }
}