<?php

namespace App\ViberHelpers;

class ViberParser
{

    private static $data;

    public function __construct($data)
    {
        self::$data = $data;
    }

    public static function getUserName()
    {
        return self::$data['sender']['name'] ?: self::$data['user']['name'];
    }

    public static function getMessage()
    {
        return isset(self::$data['message']) ? self::$data['message']['text'] : '';
    }

    public static function getChatId()
    {
        if (isset(self::$data['user'])) {
            return self::$data['user']['id'];
        } elseif (isset(self::$data['sender'])) {
            return self::$data['sender']['id'];
        }
    }

}