<?php

namespace App\Commands\CreateCard;

use App\Commands\BaseCommand;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class Email extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status == UserStatusService::EMAIL) {
            $this->user->email = $this->update->getMessage()->getText();
            $this->user->save();

            $this->triggerCommand(SocialNetworks::class);
        } else {
            $this->user->status = UserStatusService::EMAIL;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['email'], new ReplyKeyboardMarkup([ [$this->text['back']],[$this->text['main_menu']]], false, true));
        }
    }

}