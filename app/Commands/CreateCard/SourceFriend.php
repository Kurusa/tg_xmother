<?php

namespace App\Commands\CreateCard;

use App\Commands\BaseCommand;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class SourceFriend extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status == UserStatusService::SOURCE_FRIEND) {
            $this->user->source_friend_name = $this->update->getMessage()->getText();
            $this->user->save();

            $this->triggerCommand(WhatDoYouExpect::class);
        } else {
            $this->user->status = UserStatusService::SOURCE_FRIEND;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['friend_name'], new ReplyKeyboardMarkup([[$this->text['back']],[$this->text['main_menu']]], false, true));
        }
    }

}