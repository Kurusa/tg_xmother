<?php

namespace App\Commands\CreateCard;

use App\Commands\BaseCommand;
use App\Models\UserChild;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class ChildBirthday extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status == UserStatusService::CHILD_BIRTHDAY) {
            list($dd, $mm, $yyyy) = explode('/', $this->update->getMessage()->getText());
            if (!checkdate($mm, $dd, $yyyy)) {
                $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['wrong_birthday_format'], new ReplyKeyboardMarkup([
                    [$this->text['main_menu']]
                ], false, true));
            } else {
                UserChild::where('user_id', $this->user->id)->where('birthday', NULL)->update([
                    'birthday' => $this->update->getMessage()->getText()
                ]);
                $this->triggerCommand(HaveMoreChild::class);
            }
        } else {
            $this->user->status = UserStatusService::CHILD_BIRTHDAY;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['child_birth'], new ReplyKeyboardMarkup([
                [$this->text['back']],
                [$this->text['main_menu']]
            ], false, true));
        }
    }

}