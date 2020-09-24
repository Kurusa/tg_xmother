<?php

namespace App\Services\ImageMakers;

use App\Utils\Api;
use CURLFile;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardRemove;

abstract class BaseImageMaker
{


    protected $width;
    protected $height;
    public $image;
    protected $data;
    protected $text;

    public function setImage($path)
    {
        if ($path) {
            $this->image = imagecreatefrompng($path);
            $this->width = imagesx($this->image);
            $this->height = imagesy($this->image);
        }
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function constructImage()
    {
        $this->name();
        $this->id();
    }

    public function sendImage($chat_id)
    {

        $bot = new Api(env('TELEGRAM_BOT_TOKEN'));

        $tmpfilename = tempnam('/tmp', 'img');
        imagepng($this->image, $tmpfilename);

        $bot->sendMessageWithKeyboard($chat_id, '💜Приєднуйся до нас в Іnstagram, щоб не пропустити конкурси, анонси зустрічей та презентації нових партнерів!😍

💜А ще в нас є спільний чат мам України, де ти можеш знайти відповідь на будь-яке питання!

💜Ознайомся з нашим списком партнерів! Отримуй знижки та насолоджуйся шопінгом з картою X-MOTHERS!🛍', new InlineKeyboardMarkup([
            [[
                'text' => 'Інстаграм',
                'url' => 'https://www.instagram.com/_xmothers_/'
            ]], [[
                'text' => 'Чат мам України',
                'url' => 'https://t.me/joinchat/GXYMWUro0Nuurla2cb7mdw'
            ]], [[
                'text' => 'Партнери Клубу',
                'url' => 'https://www.xmothers.com/nashu-parters/'
            ]],
        ]));

        $bot->sendPhoto($chat_id, new CURLFile($tmpfilename));

        unlink($tmpfilename);
    }

    abstract function name();

    abstract function id();

}