<?php

namespace App\Commands\CreateCard;

use App\Commands\BaseCommand;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class ChildBirth extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status == UserStatusService::CHILD_BIRTH) {
            list($dd, $mm, $yyyy) = explode('/', $this->update->getMessage()->getText());
            if (!checkdate($mm, $dd, $yyyy)) {
                $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['wrong_birthdate_format'], new ReplyKeyboardMarkup([
                    [$this->text['main_menu']]
                ], false, true));
            } else {
                $this->user->child_birth = $this->update->getMessage()->getText();
                $this->user->save();

                $this->triggerCommand(SelectSource::class);
            }
        } else {
            $this->user->status = UserStatusService::CHILD_BIRTH;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['birth_date'], new ReplyKeyboardMarkup([
                [$this->text['back']],
                [$this->text['main_menu']]
            ], false, true));
        }
    }

}