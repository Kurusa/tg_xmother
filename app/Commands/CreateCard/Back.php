<?php

namespace App\Commands\CreateCard;

use App\Commands\BaseCommand;
use App\Services\Status\UserStatusService;

class Back extends BaseCommand
{

    function processCommand()
    {
        switch ($this->user->status) {
            case UserStatusService::USER_BIRTHDAY:
                $this->triggerCommand(CardName::class);
                break;
            case UserStatusService::LOCATION_TYPE_SELECT:
                $this->triggerCommand(UserBirthday::class);
                break;
            case UserStatusService::CITY_NAME:
            case UserStatusService::DISTRICT_SELECT:
            case UserStatusService::LOCATION_SELECTING:
            case UserStatusService::PHONE_NUMBER:
                $this->triggerCommand(LocationTypeSelect::class);
                break;
            case UserStatusService::EMAIL:
                $this->triggerCommand(PhoneNumber::class);
                break;
            case UserStatusService::SOCIAL_NETWORKS:
                $this->triggerCommand(Email::class);
                break;
            case UserStatusService::ARE_YOU_MOM:
                $this->triggerCommand(SocialNetworks::class);
                break;
            case UserStatusService::CHILD_GENDER:
            case UserStatusService::ARE_YOU_PREGNANT:
                $this->triggerCommand(AreYouMom::class);
                break;
            case UserStatusService::CHILD_BIRTHDAY:
                $this->triggerCommand(ChildGender::class);
                break;
            case UserStatusService::CHILD_BIRTH:
            case UserStatusService::SELECT_SOURCE:
                $this->triggerCommand(AreYouPregnant::class);
                break;
            case UserStatusService::SOURCE_FRIEND:
            case UserStatusService::EXPECT:
                $this->triggerCommand(SelectSource::class);
                break;
            case UserStatusService::HAVE_MORE_CHILD:
                $this->triggerCommand(ChildBirthday::class);
                break;
        }
    }

}