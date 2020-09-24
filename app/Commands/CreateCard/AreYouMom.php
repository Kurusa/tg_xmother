<?php

namespace App\Commands\CreateCard;

use App\Commands\BaseCommand;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class AreYouMom extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status == UserStatusService::ARE_YOU_MOM) {
            if ($this->update->getMessage()->getText() == $this->text['yes']) {
                $this->triggerCommand(ChildGender::class);
            } else {
                $this->triggerCommand(AreYouPregnant::class);
            }
        } else {
            $this->user->status = UserStatusService::ARE_YOU_MOM;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['are_you_mom'], new ReplyKeyboardMarkup([
                [$this->text['yes'], $this->text['no']],
                [$this->text['back']],
                [$this->text['main_menu']]
            ], false, true));
        }
    }

}