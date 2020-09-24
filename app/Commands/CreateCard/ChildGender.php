<?php

namespace App\Commands\CreateCard;

use App\Commands\BaseCommand;
use App\Models\UserChild;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class ChildGender extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status == UserStatusService::CHILD_GENDER) {
            UserChild::create([
                'user_id' => $this->user->id,
                'gender' => $this->update->getMessage()->getText() == $this->text['girl'] ? 1 : 0
            ]);
            $this->triggerCommand(ChildBirthday::class);
        } else {
            $this->user->status = UserStatusService::CHILD_GENDER;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['child_gender'], new ReplyKeyboardMarkup([
                [$this->text['girl'], $this->text['boy']],
                [$this->text['back']],
                [$this->text['main_menu']]
            ], false, true));
        }
    }

}