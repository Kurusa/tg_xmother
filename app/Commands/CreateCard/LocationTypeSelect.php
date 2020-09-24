<?php

namespace App\Commands\CreateCard;

use App\Commands\BaseCommand;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class LocationTypeSelect extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status === UserStatusService::LOCATION_TYPE_SELECT) {
            switch ($this->update->getMessage()->getText()) {
                case $this->text['send_city_name']:
                    $this->triggerCommand(ByCityName::class);
                    break;
                case $this->text['choose_from_list']:
                    $this->triggerCommand(DistrictSelect::class);
                    break;
            }
        } else {
            $this->user->status = UserStatusService::LOCATION_TYPE_SELECT;
            $this->user->save();

            $buttons = [];
            $buttons[] = [$this->text['choose_from_list']];
            $buttons[] = [$this->text['send_city_name']];
            $buttons[] = [$this->text['back']];
            $buttons[] = [$this->text['main_menu']];

            $this->user->save();
            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['how_choose_city_question'], new ReplyKeyboardMarkup($buttons, false, true));
        }
    }

}