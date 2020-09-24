<?php

namespace App\Commands\CreateCard;

use App\Commands\BaseCommand;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class SelectSource extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status == UserStatusService::SELECT_SOURCE) {
            $answers = array_flip($this->text['source_answers']);
            $answer = $answers[$this->update->getMessage()->getText()];
            $this->user->source = $answer;
            $this->user->save();

            if ($this->user->source == 'friend') {
                $this->triggerCommand(SourceFriend::class);
            } else {
                $this->triggerCommand(WhatDoYouExpect::class);
            }
        } else {
            $this->user->status = UserStatusService::SELECT_SOURCE;
            $this->user->save();

            $buttons = [];
            foreach ($this->text['source_answers'] as $key => $answer) {
                $buttons[] = [$answer];
            }
            $buttons[] = [$this->text['back']];
            $buttons[] = [$this->text['main_menu']];
            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['source_question'], new ReplyKeyboardMarkup($buttons, false, true));
        }
    }

}