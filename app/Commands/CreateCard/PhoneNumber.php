<?php

namespace App\Commands\CreateCard;

use App\Commands\BaseCommand;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class PhoneNumber extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status == UserStatusService::PHONE_NUMBER) {
            if ($this->update->getMessage()->getContact()) {
                $this->user->phone_number = $this->update->getMessage()->getContact()->getPhoneNumber();
                $this->user->save();

                $this->triggerCommand(Email::class);
            } else {
                $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['wrong_phone'], new ReplyKeyboardMarkup([
                    [['text' => $this->text['send_phone'], 'request_contact' => true]],
                ], false, true));
            }
        } else {
            $this->user->status = UserStatusService::PHONE_NUMBER;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['phone_number'], new ReplyKeyboardMarkup([
                [['text' => $this->text['send_phone'], 'request_contact' => true]], [$this->text['back']]
            ], false, true));
        }
    }

}