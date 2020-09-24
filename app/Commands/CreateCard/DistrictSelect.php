<?php

namespace App\Commands\CreateCard;

use App\Commands\BaseCommand;
use App\Models\District;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class DistrictSelect extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status === UserStatusService::DISTRICT_SELECT) {
            if ($this->update->getMessage()->getText() == $this->text['back']) {
                $this->triggerCommand(LocationTypeSelect::class);
            } else {
                $possible_district = District::where('title_ua', 'like', '%' . $this->update->getMessage()->getText() . '%')
                    ->orWhere('title_ru', 'like', '%' . $this->update->getMessage()->getText() . '%')
                    ->orWhere('title_en', 'like', '%' . $this->update->getMessage()->getText() . '%')
                    ->get(['id']);
                if ($possible_district->count()) {
                    $this->user->district_id = $possible_district[0]['id'];
                    $this->user->save();
                    $this->triggerCommand(CitySelect::class);
                } else {
                    $this->getBot()->sendMessage($this->user->chat_id, $this->text['cant_find_city']);
                }
            }
        } elseif ($this->user->status === UserStatusService::LOCATION_TYPE_SELECT) {
            $district_list = District::all();

            $data_list = [];
            foreach ($district_list as $district) {
                $data_list[] = [$district->title_ua];
            }
            $data_list[] = [$this->text['back']];

            $this->user->status = UserStatusService::DISTRICT_SELECT;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['select_district'], new ReplyKeyboardMarkup($data_list, false, true));
        }
    }

}