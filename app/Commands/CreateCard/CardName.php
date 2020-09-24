<?php

namespace App\Commands\CreateCard;

use App\Commands\BaseCommand;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class CardName extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status == UserStatusService::CARD_NAME) {
            $this->user->card_name = $this->update->getMessage()->getText();
            $this->user->save();

            $this->triggerCommand(UserBirthday::class);
        } else {
            $this->user->status = UserStatusService::CARD_NAME;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['card_name'], new ReplyKeyboardMarkup([[$this->text['main_menu']]], false, true));
        }
    }

}