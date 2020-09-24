<?php

namespace App\Commands\Mailing;

use App\Commands\BaseCommand;
use App\Commands\MainMenu;
use App\Models\Mailing;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class MailingImage extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status == UserStatusService::MAILING_IMAGE) {
            if ($this->update->getMessage()->getText() == 'скасувати') {
                $this->triggerCommand(MainMenu::class);
            } elseif ($this->update->getMessage()->getText() == 'пропустити') {
                $this->triggerCommand(MailingButtonTextQuestion::class);
            } else {
                Mailing::where('user_id', $this->user->id)->update([
                    'image' => $this->update->getMessage()->getPhoto()[0]->getFileId()
                ]);
                $this->triggerCommand(MailingButtonTextQuestion::class);
            }
        } else {
            $this->user->status = UserStatusService::MAILING_IMAGE;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, 'Бажаєте додати фото?', new ReplyKeyboardMarkup([
                ['пропустити', 'скасувати'],
            ], false, true));
        }
    }

}