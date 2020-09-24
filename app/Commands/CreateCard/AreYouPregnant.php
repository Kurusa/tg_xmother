<?php

namespace App\Commands\CreateCard;

use App\Commands\BaseCommand;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class AreYouPregnant extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status == UserStatusService::ARE_YOU_PREGNANT) {
            if ($this->update->getMessage()->getText() == $this->text['yes']) {
                $this->user->is_pregnant = 1;
                $this->user->save();
                $this->triggerCommand(ChildBirth::class);
            } else {
                $this->triggerCommand(SelectSource::class);
            }
        } else {
            $this->user->status = UserStatusService::ARE_YOU_PREGNANT;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['are_you_pregnant'], new ReplyKeyboardMarkup([
                [$this->text['yes'], $this->text['no']],
                [$this->text['back']],
                [$this->text['main_menu']]
            ], false, true));
        }
    }

}