<?php

namespace App\Commands\Mailing;

use App\Commands\BaseCommand;
use App\Commands\MainMenu;
use App\Models\Mailing;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class WhomToSend extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status == UserStatusService::WHOM_TO_SEND) {
            if ($this->update->getMessage()->getText() == 'скасувати') {
                $this->triggerCommand(MainMenu::class);
            } else {
                $mailing = Mailing::where('user_id', $this->user->id)->update([
                    'whom' => $this->update->getMessage()->getText()
                ]);
                $this->triggerCommand(StartMailing::class);
            }
        } else {
            $this->user->status = UserStatusService::WHOM_TO_SEND;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, 'Кому робити розсилку?', new ReplyKeyboardMarkup([
                ['телеграм', 'вайбер'],
                ['скасувати'],
            ], false, true));
        }
    }

}