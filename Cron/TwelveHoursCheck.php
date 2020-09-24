<?php

use App\Utils\Api;
use App\ViberHelpers\ViberApi;

require_once(__DIR__ . '/../bootstrap.php');

$text = require(__DIR__ . '/../app/config/bot.php');
$bot = new Api(env('TELEGRAM_BOT_TOKEN'));
$viber = new ViberApi();
$telegram_button[] = [[
    'text' => $text['twelve_notify_button_text'],
    'url' => $text['twelve_notify_button_url']
]];
$viber_button = [
    'Columns' => 6,
    'Rows' => 1,
    'BgColor' => '#e2c9ff',
    'TextOpacity' => 60,
    'TextSize' => 'large',
    "ActionType" => "open-url",
    "ActionBody" => $text['twelve_notify_button_url'],
    'Text' => $text['twelve_notify_button_text'],
];
$user_list = \App\Models\User::where('updated_at', '<', \Carbon\Carbon::now()->subHours(24))->where('twelve_notified', 0)->where('is_blocked', 0)->where('have_card', 0)->get();

$return = true;
foreach ($user_list as $user) {
    if ($user->chat_id) {
        $return = $bot->sendMessageWithKeyboard($user->chat_id, 'Привіт, ' . $user->first_name . '!'
            . $text['twelve_notify_text'], new \TelegramBot\Api\Types\Inline\InlineKeyboardMarkup($telegram_button));
    }
    if ($user->viber_chat_id) {
        $viber->sendMessageWithKeyboard($user->first_name . '!'
            . $text['twelve_notify_text'], $viber_button, $user->viber_chat_id);
    }

    if (!$return) {
        $user->is_blocked = 1;
    }
    $user->twelve_notified = 1;
    $user->save();
}