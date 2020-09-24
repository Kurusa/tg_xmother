<?php

namespace App\Commands\CreateCard;

use App\Commands\BaseCommand;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class Done extends BaseCommand
{

    function processCommand()
    {
        $maker = new \App\Services\ImageMakers\ImageMakerMain();
        $maker->setImage(__DIR__ . '/../../Services/ImageMakers/template.png');
        $maker->setData([
            'name' => $this->user->card_name,
            'id' => $this->user->id
        ]);
        $maker->constructImage();
        $maker->sendImage($this->user->chat_id);
        $this->user->status = UserStatusService::DONE;
        $this->user->have_card = 1;
        $this->user->save();


        $buttons[] = [[
            'text' => $this->text['instruction_button'],
            'url' => $this->text['instruction_button_link']
        ]];
        $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['card_done_message'], new InlineKeyboardMarkup($buttons));
    }

}