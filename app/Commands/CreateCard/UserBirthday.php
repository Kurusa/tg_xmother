<?php

namespace App\Commands\CreateCard;

use App\Commands\BaseCommand;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class UserBirthday extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status == UserStatusService::USER_BIRTHDAY) {
            $this->user->user_birthday = $this->update->getMessage()->getText();
            $this->user->save();

            $this->triggerCommand(LocationTypeSelect::class);
        } else {
            $this->user->status = UserStatusService::USER_BIRTHDAY;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, 'Введіть Вашу дату народження у форматі дд/мм/рррр', new ReplyKeyboardMarkup([[$this->text['back']], [$this->text['main_menu']]], false, true));
        }
    }

}