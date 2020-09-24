<?php

namespace App\Commands\CreateCard;

use App\Commands\BaseCommand;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class WhatDoYouExpect extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status == UserStatusService::EXPECT) {
            if ($this->update->getMessage()->getText() == $this->text['done']) {
                $this->triggerCommand(Done::class);
                exit();
            }
            $expect = array_flip($this->text['expects']);
            $answer = $expect[$this->update->getMessage()->getText()];
            $this->user->club_expectation = $this->user->club_expectation . ',' . $answer;
            $this->user->save();

            $expects = explode(',', $this->user->club_expectation);
            $buttons = [];
            foreach ($this->text['expects'] as $key => $answer) {
                if (!in_array($key, $expects)) {
                    $buttons[] = [$answer];
                }
            }

            $buttons[] = [$this->text['done']];
            $buttons[] = [$this->text['main_menu']];
            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['what_do_you_expect'], new ReplyKeyboardMarkup($buttons, false, true));
        } else {
            $this->user->status = UserStatusService::EXPECT;
            $this->user->save();

            $buttons = [];
            foreach ($this->text['expects'] as $key => $answer) {
                $buttons[] = [$answer];
            }
            $buttons[] = [$this->text['main_menu']];
            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['what_do_you_expect'], new ReplyKeyboardMarkup($buttons, false, true));
        }
    }

}