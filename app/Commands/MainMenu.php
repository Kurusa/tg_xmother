<?php

namespace App\Commands;

use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardRemove;

class MainMenu extends BaseCommand
{

    function processCommand($text = false)
    {
        $this->user->status = UserStatusService::DONE;
        $this->user->save();
        $buttons = [];

        if (!$this->user->club_expectation) {
            $buttons[] = [[
                'text' => $this->text['become_mother_partner'],
                'callback_data' => json_encode([
                    'a' => 'become_mother_partner'
                ])
            ]];
        }
        $buttons[] = [[
            'text' => $this->text['become_partner'],
            'url' => 'https://www.xmothers.com/spivprachya/'
        ]];
        $buttons[] = [[
            'text' => $this->text['become_club_partner'],
            'url' => 'https://docs.google.com/forms/d/1TcbtRSEAtWRXRZU4psv31tHfR_PTsf_-jpsUyP0aH68/edit'
        ]];
        $buttons[] = [[
            'text' => $this->text['im_bloger'],
            'url' => 'https://www.xmothers.com/spivprachya/'
        ]];
        $buttons[] = [[
            'text' => $this->text['about_club'],
            'url' => 'https://www.xmothers.com/pro-klub/'
        ]];
        $buttons[] = [[
            'text' => $this->text['faq'],
            'callback_data' => json_encode([
                'a' => 'faq'
            ])
        ]];
        $buttons[] = [[
            'text' => $this->text['our_partners'],
            'url' => 'https://www.xmothers.com/nashu-parters/'
        ]];
        $buttons[] = [[
            'text' => $this->text['find_chat'],
            'url' => 'https://www.xmothers.com/cat/'
        ]];
        $buttons[] = [
            [
                'text' => $this->text['facebook'],
                'url' => 'https://www.facebook.com/xmothers'
            ], [
                'text' => $this->text['instagram'],
                'url' => 'https://www.instagram.com/_xmothers_/'
            ]
        ];
        $buttons[] = [[
            'text' => $this->text['feedback'],
            'callback_data' => json_encode([
                'a' => 'feedback'
            ])
        ]];

        if ($this->user->user_name == 'Kurusa' || $this->user->user_name == 'xmothers_ua') {
            $buttons[] = [[
                'text' => 'Створити розсилку',
                'callback_data' => json_encode([
                    'a' => 'mailing'
                ])
            ]];
        }

        if ($this->update->getMessage()->getText() == '/start') {
            $text = $this->text['start_message'];
        } elseif ($this->user->club_expectation) {
            $text = $this->text['start_message'];
        } else {
            $text = 'Привіт! Це знову я - X-ботик!😎
Хочеш стати учасницею клубу X-Mothers? Чи можливо бажаєш спочатку дізнатися про переваги та привілеї учасниць? Роби свій вибір та натискай на кнопки нижче! Пам’ятай, ти завжди можеш повернутися в меню командою - /menu';
        }

        $this->getBot()->sendPhoto($this->user->chat_id, new \CURLFile(__DIR__ . '/../../src/OLE_7432 — копия.jpg'));
        $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $text, new InlineKeyboardMarkup($buttons));
    }

}