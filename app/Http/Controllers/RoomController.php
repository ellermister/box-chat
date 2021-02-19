<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Longman\TelegramBot\Entities\InputMedia\InputMedia;
use Longman\TelegramBot\Entities\InputMedia\InputMediaPhoto;
use Longman\TelegramBot\Telegram;

class RoomController extends Controller
{
    /**
     * 展示聊天室页面
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function showGuestRoom(Request $request)
    {
        $settings = Setting::getAll(['room_name', 'room_desc', 'room_avatar','site_keyword','site_description']);
        return view('room',['settings' => $settings]);
    }

    /**
     * 获取聊天室信息
     * @param Request $request
     */
    public function getRoomProfile(Request $request)
    {
        $list = Setting::getAll(['room_name', 'room_desc', 'room_avatar']);
        return ee_json('profile', 200, $list);
    }

    public function getMessages(Request $request)
    {
        $uuid = $request->input('uuid');
        $last_id = $request->input('last_id');
        $user = DB::table('users')->where('uuid', $uuid)->first();
        if (!$user) {
            return ee_json('用户不存在', 500);
        }
        $build = DB::table('messages')->where(function ($build) use ($user) {
            $build->where('from_user_id', $user->id)->orWhere('to_user_id', $user->id);
        });
        if ($last_id) {
            $build->where('id', '>', $last_id);
        }
        $messages = $build->get();
        $messages->each(function ($message) {
            if ($message->sticker_path) {
                $message->sticker_path = Storage::url($message->sticker_path);
            }
            if ($message->media && preg_match('#^/?public#', $message->media)) {
                $message->media = Storage::url($message->media);
            }
            if ($message->message_text === null) {
                $message->message_text = '';
            }
        });
        $last_id = $messages->last() ? $messages->last()->id : 0;
        return ee_json('消息列表', 200, ['messages' => $messages, 'last_id' => $last_id]);
    }

    /**
     * 发送消息
     *
     * @param Request $request
     * @param Telegram $telegram
     * @return array
     * @throws \Longman\TelegramBot\Exception\TelegramException
     */
    public function sendMessage(Request $request, Telegram $telegram)
    {
        $text = $request->input('text', '');
        $media = $request->input('media', '');
        $uuid = $request->input('uuid', '');
        $request_id = $request->input('request_id', '');
        $reply_id = $request->input('reply_id', 0);

        $chat_id = env('TELEGRAM_RECEIVE_ID');
        $user = DB::table('users')->where('uuid', $uuid)->first();
        if (!$user) {
            return ee_json('用户不存在', 500);
        }

        $extentData = [];

        if ($media) {
            $media_list = [];
            if(is_string($media)){
                $media_list[] = $media;
            }elseif(is_array($media)){
                $media_list = array_column($media,'url');
            }
            if(count($media_list) > 1){
                $inputMediaPhoto = [];
                foreach ($media_list as $item){
                    $photo = $item;
                    if (!preg_match('#^https?\://#is', $photo)) {
                        $photo = preg_replace('#^/?storage/#', '', $photo);
                        $storagePath = storage_path('app/public/' . $photo);
                        $photo = \Longman\TelegramBot\Request::encodeFile($storagePath);
                    }

                    $inputMediaPhoto[] = new InputMediaPhoto([
                        'type'    => 'photo',
                        'media'   => $photo,
                        'caption' => strval($text),
                    ]);
                }

                $result = \Longman\TelegramBot\Request::sendMediaGroup([
                    'chat_id' => $chat_id,
                    'media'   => $inputMediaPhoto
                ]);

                if ($result->isOk() && $messagesResult = $result->getResult()) {
                    $groupData = [];
                    foreach($messagesResult as $index => $message){
                        $baseData = [
                            'from_name'      => $user->name,
                            'message_text'   => $text,
                            'message_id'     => $message->message_id,
                            'media_group_id' => $message->media_group_id,
                            'chat_id'        => $chat_id,
                            'from_id'        => 0,
                            'reply_id'       => $reply_id,
                            'from_user_id'   => $user->id,
                            'request_id'     => $request_id,
                            'created_at'     => time(),
                            'updated_at'     => time()
                        ];
                        $mediaItem = $message->getPhoto();
                        $groupData[] = array_merge($baseData,[
                            'media'        => $media_list[$index],
                            'media_type'   => 1,
                            'media_width'  => end($mediaItem)->getWidth(),
                            'media_height' => end($mediaItem)->getHeight()
                        ]);
                    }
                    $res = DB::table('messages')->insert($groupData);
                    return ee_json('发送成功', 200, ['local' => $res, 'result' => $result]);
                }
                return ee_json('发送失败', 500, ['result' => $result]);
            }else{
                $photo = $media;
                if (!preg_match('#^https?\://#is', $photo)) {
                    $photo = preg_replace('#^/?storage/#', '', $photo);
                    $storagePath = storage_path('app/public/' . $photo);
                    $photo = \Longman\TelegramBot\Request::encodeFile($storagePath);
                }
                $result = \Longman\TelegramBot\Request::sendPhoto([
                    'chat_id'             => $chat_id,
                    'photo'               => $photo,
                    'caption'             => $text,
                    'reply_to_message_id' => $reply_id
                ]);

                if ($result->isOk() && $photoResult = $result->getResult()->getPhoto()) {
                    $extentData = [
                        'media'        => $media,
                        'media_type'   => 1,
                        'media_width'  => $photoResult[0]->getWidth(),
                        'media_height' => $photoResult[0]->getHeight(),
                    ];
                }
            }

        } else {
            $result = \Longman\TelegramBot\Request::sendMessage([
                'chat_id'             => $chat_id,
                'text'                => $text,
                'reply_to_message_id' => $reply_id
            ]);
        }

        if ($result->isOk()) {
            $res = DB::table('messages')->insert(array_merge([
                'from_name'    => $user->name,
                'message_text' => $text,
                'message_id'   => $result->getResult()->message_id,
                'chat_id'      => $chat_id,
                'from_id'      => 0,
                'reply_id'     => $reply_id,
                'from_user_id' => $user->id,
                'request_id'   => $request_id,
                'created_at'   => time(),
                'updated_at'   => time()
            ], $extentData));
            $insertId = DB::getPdo()->lastInsertId();
            return ee_json('发送成功', 200, ['local' => $res, 'id' => $insertId, 'result' => $result]);
        }
        return ee_json('发送失败', 500, $result->printError());
    }

    public function setUserName(Request $request)
    {
        $name = $request->input('name', '');
        $remark = $request->input('remark', '');

        $uuid = uuid();
        $res = DB::table('users')->insert([
            'name'       => $name,
            'remark'     => $remark,
            'uuid'       => $uuid,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        if ($res) {
            return ee_json('ok', 200, ['uuid' => $uuid]);
        }
        return ee_json('设置用户失败', 500);
    }


    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $name = sprintf("%s.%s", $file->getBasename(), $file->extension());
            $storagePath = md5($name) . $file->extension();
            $file->storeAs('/public/upload/', $storagePath);
            $url = Storage::url('upload/' . $storagePath);
            return ee_json('ok', 200, ['url' => $url]);
        }
        return ee_json('未上传图片', 500);
    }
}
