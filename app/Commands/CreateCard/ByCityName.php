<?php

namespace App\Commands\CreateCard;

use App\Commands\BaseCommand;
use App\Models\City;
use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class ByCityName extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status === UserStatusService::CITY_NAME) {
            if ($this->update->getMessage()->getText() == $this->text['back']) {
                $this->triggerCommand(LocationTypeSelect::class);
            } else {
                if (strlen(trim($this->update->getMessage()->getText())) > 3) {
                    $possible_city_list = City::where('title_ua', 'like', '%' . $this->update->getMessage()->getText() . '%')
                        ->orWhere('title_ru', 'like', '%' . $this->update->getMessage()->getText() . '%')
                        ->orWhere('title_en', 'like', '%' . $this->update->getMessage()->getText() . '%')
                        ->get();

                    if ($possible_city_list->count()) {
                        $this->user->status = UserStatusService::LOCATION_SELECTING;
                        $this->user->save();

                        $city_list = [];
                        foreach ($possible_city_list as $city) {
                            $city_list[] = [$city->title_ua . ', ' . $city->district->title_ua . $this->text['district']];
                        }
                        $city_list[] = [$this->text['back']];

                        $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['did_you_mean_this_city'], new ReplyKeyboardMarkup($city_list, false, true));
                    } else {
                        $this->getBot()->sendMessage($this->user->chat_id, $this->text['cant_find_city']);
                    }
                } else {
                    $this->getBot()->sendMessage($this->user->chat_id, $this->text['more_symbols']);
                }
            }
        } elseif ($this->user->status === UserStatusService::LOCATION_TYPE_SELECT) {
            $this->user->status = UserStatusService::CITY_NAME;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['request_to_write_city'], new ReplyKeyboardMarkup([
                [$this->text['back']],
            ], false, true));
        }
    }

}