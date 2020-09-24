<?php

namespace App\Commands\Mailing;

use App\Commands\BaseCommand;
use App\Commands\MainMenu;
use App\Models\Mailing;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class MailingButtonTextQuestion extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status == UserStatusService::MAILING_BUTTON_TEXT_QUESTION) {
            if ($this->update->getMessage()->getText() == 'скасувати') {
                $this->triggerCommand(MainMenu::class);
            } else {
                if ($this->update->getMessage()->getText() == 'так') {
                    $this->triggerCommand(MailingButtonText::class);
                } else {
                    $this->triggerCommand(WhomToSend::class);
                }
            }
        } else {
            $this->user->status = UserStatusService::MAILING_BUTTON_TEXT_QUESTION;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, 'Бажаєте додати кнопку до розсилки?', new ReplyKeyboardMarkup([
                ['так', 'ні'],
                ['скасувати'],
            ], false, true));
        }
    }

}