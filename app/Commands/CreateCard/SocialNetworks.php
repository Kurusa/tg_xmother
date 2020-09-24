<?php

namespace App\Commands\CreateCard;

use App\Commands\BaseCommand;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class SocialNetworks extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status == UserStatusService::SOCIAL_NETWORKS) {
            $this->user->social_networks = $this->update->getMessage()->getText();
            $this->user->save();

            $this->triggerCommand(AreYouMom::class);
        } else {
            $this->user->status = UserStatusService::SOCIAL_NETWORKS;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['contact'], new ReplyKeyboardMarkup([ [$this->text['back']],[$this->text['main_menu']]], false, true));
        }
    }

}