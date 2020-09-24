<?php

use App\Services\Status\UserStatusService;

return [
    UserStatusService::FAQ => \App\Commands\Faq::class,
    UserStatusService::CREATE_CARD_START => \App\Commands\CreateCard\CardName::class,
    UserStatusService::CARD_NAME => \App\Commands\CreateCard\CardName::class,
    UserStatusService::LOCATION_TYPE_SELECT => \App\Commands\CreateCard\LocationTypeSelect::class,
    UserStatusService::LOCATION_SELECTING => \App\Commands\CreateCard\LocationDone::class,
    UserStatusService::CITY_NAME => \App\Commands\CreateCard\ByCityName::class,
    UserStatusService::DISTRICT_SELECT => \App\Commands\CreateCard\DistrictSelect::class,
    UserStatusService::PHONE_NUMBER => \App\Commands\CreateCard\PhoneNumber::class,
    UserStatusService::EMAIL => \App\Commands\CreateCard\Email::class,
    UserStatusService::SOCIAL_NETWORKS => \App\Commands\CreateCard\SocialNetworks::class,
    UserStatusService::ARE_YOU_MOM => \App\Commands\CreateCard\AreYouMom::class,
    UserStatusService::CHILD_GENDER => \App\Commands\CreateCard\ChildGender::class,
    UserStatusService::CHILD_BIRTHDAY => \App\Commands\CreateCard\ChildBirthday::class,
    UserStatusService::HAVE_MORE_CHILD => \App\Commands\CreateCard\HaveMoreChild::class,
    UserStatusService::ARE_YOU_PREGNANT => \App\Commands\CreateCard\AreYouPregnant::class,
    UserStatusService::CHILD_BIRTH => \App\Commands\CreateCard\ChildBirth::class,
    UserStatusService::SELECT_SOURCE => \App\Commands\CreateCard\SelectSource::class,
    UserStatusService::SOURCE_FRIEND => \App\Commands\CreateCard\SourceFriend::class,
    UserStatusService::EXPECT => \App\Commands\CreateCard\WhatDoYouExpect::class,
    UserStatusService::USER_BIRTHDAY => \App\Commands\CreateCard\UserBirthday::class,
    UserStatusService::FEEDBACK => \App\Commands\Feedback::class,
    UserStatusService::MAILING_TEXT => \App\Commands\Mailing\MailingText::class,
    UserStatusService::MAILING_IMAGE => \App\Commands\Mailing\MailingImage::class,
    UserStatusService::MAILING_BUTTON_TEXT_QUESTION => \App\Commands\Mailing\MailingButtonTextQuestion::class,
    UserStatusService::MAILING_BUTTON_TEXT => \App\Commands\Mailing\MailingButtonText::class,
    UserStatusService::MAILING_BUTTON_TEXT_URL => \App\Commands\Mailing\MailingButtonTextUrl::class,
    UserStatusService::WHOM_TO_SEND => \App\Commands\Mailing\WhomToSend::class,
];