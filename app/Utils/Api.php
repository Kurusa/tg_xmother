<?php

namespace App\Utils;

use TelegramBot\Api\BotApi;
use TelegramBot\Api\HttpException;

class Api extends BotApi
{

    public function __construct($token, $trackerToken = null)
    {
        parent::__construct($token, $trackerToken);
    }

    public function sendMessageWithKeyboard($chat_id, string $text, $keyboard)
    {
        try {
            return $this->sendMessage($chat_id, $text, 'HTML', true, null, $keyboard);
        } catch (HttpException $e) {
            return false;
        }
    }

}