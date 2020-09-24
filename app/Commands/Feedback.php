<?php

namespace App\Commands;

use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class Feedback extends BaseCommand
{

    function processCommand()
    {
        if ($this->user->status == UserStatusService::FEEDBACK) {
            if ($this->update->getMessage()->getText()) {
                \App\Models\Feedback::create([
                    'user_id' => $this->user->id,
                    'text' => $this->update->getMessage()->getText() ?: '',
                    'image' => $this->update->getMessage()->getPhoto() ? $this->update->getMessage()->getPhoto()[0]->getFileId() : ''
                ]);

                $this->getBot()->sendMessage(906203059, $this->update->getMessage()->getText() . "\n" . '<a href="tg://user?id=' . $this->user->chat_id . '">Користувач</a>', 'html');
            } elseif ($this->update->getMessage()->getPhoto()) {
                \App\Models\Feedback::create([
                    'user_id' => $this->user->id,
                    'text' => $this->update->getMessage()->getCaption() ?: '',
                    'image' => $this->update->getMessage()->getPhoto()[0]->getFileId()
                ]);
                $this->getBot()->sendPhoto(906203059, $this->update->getMessage()->getPhoto()[0]->getFileId(), '<a href="tg://user?id=' . $this->user->chat_id . '">Користувач</a>', null, null, null, 'html');
            }
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

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, 'Дякуємо за звернення! Вашу заявку опрацюють найближчим часом!', new InlineKeyboardMarkup($buttons));
        } else {
            $this->user->status = UserStatusService::FEEDBACK;
            $this->user->save();

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['feedback_text'], new ReplyKeyboardMarkup([
                [$this->text['main_menu']]
            ], false, true));
        }
    }

}