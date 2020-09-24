<?php

namespace App\Commands\Mailing;

use App\Commands\BaseCommand;
use App\Commands\MainMenu;
use App\Models\Mailing;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class MailingText extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status == UserStatusService::MAILING_TEXT) {
            if ($this->update->getMessage()->getText() == 'скасувати') {
                $this->triggerCommand(MainMenu::class);
            } else {
                Mailing::where('user_id', $this->user->id)->update([
                    'text' => $this->update->getMessage()->getText()
                ]);
                $this->triggerCommand(MailingImage::class);
            }
        } else {
            $this->getBot()->deleteMessage($this->user->chat_id, $this->update->getCallbackQuery()->getMessage()->getMessageId());
            $this->user->status = UserStatusService::MAILING_TEXT;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, 'Введіть текст розсилки', new ReplyKeyboardMarkup([
                ['скасувати'],
            ], false, true));
        }
    }

}