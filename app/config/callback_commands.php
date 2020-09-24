<?php
return [
    'become_mother_partner' => \App\Commands\CreateCard\Start::class,
    'faq' => \App\Commands\Faq::class,
    'feedback' => \App\Commands\Feedback::class,
    'mailing' => \App\Commands\Mailing\Create::class,
    'set' => \App\Commands\Mailing\Create::class,
    'set_sub' => \App\Commands\Mailing\Create::class,
    'unset' => \App\Commands\Mailing\Create::class,
    'unset_sub' => \App\Commands\Mailing\Create::class,
    'back_to_values' => \App\Commands\Mailing\Create::class,

    'all_users' => \App\Commands\Mailing\Create::class,
    'user_pregnant' => \App\Commands\Mailing\Create::class,
    'with_child' => \App\Commands\Mailing\Create::class,
    'user_city' => \App\Commands\Mailing\Create::class,
    'user_expects' => \App\Commands\Mailing\Create::class,
    'mailing_text' => \App\Commands\Mailing\MailingText::class,
];