<?php

use App\Utils\Api;
use App\ViberHelpers\ViberApi;

require_once(__DIR__ . '/../bootstrap.php');

$text = require(__DIR__ . '/../app/config/bot.php');
$bot = new Api(env('TELEGRAM_BOT_TOKEN'));
$viber = new ViberApi();

$user_list = \App\Models\User::where('updated_at', '<', \Carbon\Carbon::now()->subHours(8))->where('eight_notified', 0)->where('is_blocked', 0)->where('have_card', 0)->get();

foreach ($user_list as $user) {
    if ($user->chat_id) {
        $bot->sendMessage($user->chat_id, $user->first_name . '!'
            . $text['eight_notify_text']);
    }
    if ($user->viber_chat_id) {
        $viber->sendMessage($user->first_name . '!'
            . $text['eight_notify_text'], $user->viber_chat_id);
    }

    $user->eight_notified = 1;
    $user->save();
}