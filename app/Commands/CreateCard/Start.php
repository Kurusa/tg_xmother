<?php

namespace App\Commands\CreateCard;

use App\Commands\BaseCommand;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class Start extends BaseCommand
{

    function processCommand()
    {
        $this->user->status = UserStatusService::CREATE_CARD_START;
        $this->user->save();

        $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['create_card_start_message'], new ReplyKeyboardMarkup([
            [
                $this->text['yes']
            ], [
                $this->text['main_menu']
            ]
        ], false, true));
    }

}