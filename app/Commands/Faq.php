<?php

namespace App\Commands;

use App\Services\Status\UserStatusService;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\ReplyKeyboardMarkup;

class Faq extends BaseCommand
{

    function processCommand()
    {

        $question_list = [
            'Розкажіть мені про клуб мам X-Mothers?',
            'Що дає карта учасниці клубу?',
            'Як стати учасницею клубу?',
            'Хто наші партнери?',
            'Як мені знайти чат мам мого міста?',
        ];

        if ($this->update->getMessage() && in_array($this->update->getMessage()->getText(), $question_list)) {
            $answer = null;
            foreach ($this->text['question_list'] as $question) {
                if ($question['question'] == $this->update->getMessage()->getText()) {
                    $answer = $question['answer'];
                    $buttons = $question['buttons'] ?: null;
                    break;
                }
            }

            if ($answer) {
                if ($buttons) {
                    $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $answer, new InlineKeyboardMarkup([$buttons]));
                } else {
                    $this->getBot()->sendMessage($this->user->chat_id, $answer, 'html');
                }
            } else {
                $this->getBot()->sendMessage($this->user->chat_id, $this->text['cant_find_answer']);
            }
        } else {
            $buttons = [];
            foreach ($this->text['question_list'] as $question) {
                $buttons[] = [
                    $question['question']
                ];
            }

            $buttons[] = [$this->text['main_menu']];

            $this->getBot()->sendMessageWithKeyboard($this->user->chat_id, $this->text['faq_menu'], new ReplyKeyboardMarkup($buttons, false, true));
        }
    }

}