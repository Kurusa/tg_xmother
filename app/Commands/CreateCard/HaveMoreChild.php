<?php

namespace App\Commands\CreateCard;

use App\Commands\BaseCommand;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class HaveMoreChild extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status == UserStatusService::HAVE_MORE_CHILD) {
            if ($this->update->getMessage()->getText() == $this->text['yes']) {
                $this->triggerCommand(ChildGender::class);
            } else {
                $this->triggerCommand(AreYouPregnant::class);
            }
        } else {
            $this->user->status = UserStatusService::HAVE_MORE_CHILD;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['have_more_child'], new ReplyKeyboardMarkup([
                [$this->text['yes'], $this->text['no']],
                [$this->text['back']],
                [$this->text['main_menu']]
            ], false, true));
        }
    }

}