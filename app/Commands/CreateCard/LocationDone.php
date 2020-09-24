<?php

namespace App\Commands\CreateCard;

use App\Commands\BaseCommand;
use App\Models\City;
use App\Services\Status\UserStatusService;

class LocationDone extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status === UserStatusService::LOCATION_SELECTING) {
            if ($this->update->getMessage()->getText() == $this->text['back']) {
                $this->triggerCommand(LocationTypeSelect::class);
            } else {
                $search_by_string = $this->update->getMessage()->getText();
                $exploded = explode(',', $this->update->getMessage()->getText());
                if ($exploded[0]) {
                    $search_by_string = $exploded[0];
                }

                $possible_city = City::where('title_ua', $search_by_string)->get();
                if ($possible_city->count()) {
                    $this->user->city_id = $possible_city[0]->id;
                    $this->user->district_id = $possible_city[0]->district->id;
                    $this->user->save();

                    $this->triggerCommand(PhoneNumber::class);
                }
            }
        }
    }
}