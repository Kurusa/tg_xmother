<?php

namespace App\Commands\Mailing;

use App\Commands\MainMenu;
use App\ViberHelpers\ViberApi;
use Illuminate\Database\Capsule\Manager as DB;

use App\Commands\BaseCommand;
use App\Models\Mailing;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class StartMailing extends BaseCommand
{

    function processCommand()
    {
        $viber = new ViberApi();
        $mailing = Mailing::where('user_id', $this->user->id)->first();
        $mailing_data = json_decode($mailing->value, true);

        if ($mailing->whom == 'телеграм') {
            $query = 'SELECT chat_id FROM user ';
        } else {
            $query = 'SELECT viber_chat_id FROM user ';
        }
        if ($mailing_data['all_users']) {
        } elseif ($mailing_data['user_pregnant']) {
            $query .= ' WHERE is_pregnant = 1 ';
        } elseif ($mailing_data['user_expects']) {
            $add_or = false;
            foreach ($mailing_data['user_expects'] as $key => $expect) {
                if ($add_or) {
                    $query .= ' OR ';
                }
                if (!$add_or) {
                    $query .= ' WHERE ';
                }
                $query .= ' club_expectation LIKE "%' . $key . '%" ';
                $add_or = true;
            }
        }

        $user_list = DB::select($query);
        foreach ($user_list as $user) {
            try {
                if ($mailing->image) {
                    if ($mailing->button) {
                        $buttons = [];
                        if ($mailing->whom == 'телеграм') {
                            $buttons[] = [json_decode($mailing->button)];
                            $this->getBot()->sendPhoto($user->chat_id, $mailing->image, $mailing->text ?: '', null, new InlineKeyboardMarkup($buttons));
                        } else {
                            $button_data = json_decode($mailing->button, true);
                            $buttons[] = [
                                'Columns' => 6,
                                'Rows' => 1,
                                'BgColor' => '#e2c9ff',
                                'TextOpacity' => 60,
                                'TextSize' => 'large',
                                "ActionType" => "open-url",
                                "ActionBody" => $button_data['url'],
                                'Text' => $button_data['text']
                            ];
                            if ($mailing->text) {
                                $viber->sendMessageWithKeyboard($mailing->text, $buttons ?: '', $user->viber_chat_id);
                            }
                        }
                    } else {
                        if ($mailing->whom == 'телеграм') {
                            $this->getBot()->sendPhoto($user->chat_id, $mailing->image, $mailing->text ?: '');
                        }
                    }
                } else {
                    if ($mailing->button) {
                        $buttons = [];
                        if ($mailing->whom == 'телеграм') {
                            $buttons[] = [json_decode($mailing->button)];
                            $this->getBot()->sendMessage($user->chat_id, $mailing->text, 'html', false, null, new InlineKeyboardMarkup($buttons));
                        } else {
                            $button_data = json_decode($mailing->button, true);
                            $buttons[] = [
                                'Columns' => 6,
                                'Rows' => 1,
                                'BgColor' => '#e2c9ff',
                                'TextOpacity' => 60,
                                'TextSize' => 'large',
                                "ActionType" => "open-url",
                                "ActionBody" => $button_data['url'],
                                'Text' => $button_data['text']
                            ];
                            if ($mailing->text) {
                                $viber->sendMessageWithKeyboard($mailing->text, $buttons, $user->viber_chat_id);
                            }
                        }
                    } else {
                        if ($mailing->whom == 'телеграм') {
                            $this->getBot()->sendMessage($user->chat_id, $mailing->text);
                        } else {
                            $viber->sendMessage($mailing->text, $user->viber_chat_id);
                        }
                    }
                }
            } catch (\Exception $exception) {
                error_log($exception->getMessage());
            }
        }

        DB::delete('DELETE FROM mailing');
        $this->triggerCommand(MainMenu::class);
    }

}