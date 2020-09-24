<?php

namespace App\Commands;

use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class Start extends BaseCommand
{

    function processCommand()
    {
        $this->triggerCommand(MainMenu::class);
    }

}

