<?php

namespace App\Commands\CreateCard;

use App\Commands\BaseCommand;
use App\Models\City;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class CitySelect extends BaseCommand
{

    function processCommand()
    {
        $city_list = City::where('district_id', $this->user->district_id)->get();

        $data_list = [];
        foreach ($city_list as $city) {
            $data_list[] = [$city->title_ua];
        }
        $data_list[] = [$this->text['back']];

        $this->user->status = UserStatusService::LOCATION_SELECTING;
        $this->user->save();

        $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['select_city'], new ReplyKeyboardMarkup($data_list, false, true));
    }

}