<?php

class TelegramException extends Exception
{
}


class Telegram
{
    private $url = "https://api.telegram.org";
    private $bot_url = "/bot";
    private $token = null;
    private $parse_mode = 'html';
    private $action = '';
    private $chat_id;
    private $request;
    private $result;
    private $reply_markup;

    function __construct($token)
    {
        $this->token = $token;

        if (is_null($this->token)) {
            throw new TelegramException('Required "token" key not supplied');
        }
    }



    public function set_chatId($chat_id = '')
    {
        $this->chat_id = $chat_id;
        return $this;
    }

    public function set_inlineKeyboard($arr = [])
    {
        $this->reply_markup['inline_keyboard'] = $arr;
        return $this;
    }

    public function set_replyKeyboard($arr = [], $remove_keyboard = false, $resize_keyboard = true)
    {
        $this->reply_markup['keyboard'] = $arr;
        $this->reply_markup['resize_keyboard'] = $resize_keyboard;
        $this->reply_markup['remove_keyboard'] = $remove_keyboard;
        $this->reply_markup['input_field_placeholder'] = "Test message";
        return $this;
    }

    public function remove_replyKeyboard()
    {
        unset($this->reply_markup['inline_keyboard']);
        return $this;
    }

    public function remove_inlineKeyboard()
    {
        unset($this->reply_markup['keyboard']);
        unset($this->reply_markup['resize_keyboard']);
        $this->reply_markup['remove_keyboard'] = true;
        return $this;
    }

    public function send_chatAction($action, $chat_id = '')
    {
        $chat_id = ($chat_id != '') ? $chat_id : $this->chat_id;
        $actions = array(
            'typing',
            'upload_photo',
            'record_video',
            'upload_video',
            'record_audio',
            'upload_audio',
            'upload_document',
            'find_location',
        );
        if (isset($action) && in_array($action, $actions)) {
            $this->result = $this->Ziyogram('sendChatAction', compact('chat_id', 'action'));
            return $this;
        }
        throw new TelegramException('Invalid Action! Accepted value: ' . implode(', ', $actions));
    }

    public function send_message($text, $chat_id = null, $disable_web_page_preview = false, $parse_mode = null)
    {
        $message['text'] = $text;
        $message['chat_id'] = (!is_null($chat_id)) ? $chat_id : $this->chat_id;
        $message['parse_mode'] = (!is_null($parse_mode)) ? $parse_mode : $this->parse_mode;
        $message['disable_web_page_preview'] = $disable_web_page_preview;

        $this->result = $this->Ziyogram('sendMessage', $message);
        return $this;
    }

    public function send_location($latitude, $longitude, $chat_id = null)
    {
        $chat_id = (!is_null($chat_id)) ? $chat_id : $this->chat_id;
        $message = compact('chat_id', 'latitude', 'longitude');
        $this->result = $this->Ziyogram('sendLocation', $message);
        return $this;
    }

    public function send_contact($phone_number, $first_name, $last_name = null, $chat_id = null)
    {
        $chat_id = (!is_null($chat_id)) ? $chat_id : $this->chat_id;
        $message = compact('chat_id', 'phone_number', 'first_name', 'last_name');
        $this->result = $this->Ziyogram('sendContact', $message);
        return $this;
    }
    public function send_answer($text, $chat_id = null, $callquery, $parse_mode = null, $alert = true)
    {
        $message['text'] = $text;
        $message['chat_id'] = (!is_null($chat_id)) ? $chat_id : $this->chat_id;
        $message['callback_query_id'] = $callquery;
        $message['parse_mode'] = (!is_null($parse_mode)) ? $parse_mode : $this->parse_mode;
        $message['show_alert'] = $alert;
        $this->Ziyogram('answerCallbackQuery', $message);
    }
    public function editMessageReplyMarkup($mid, $qid, $chat_id = null,)
    {
        $message['chat_id'] = (!is_null($chat_id)) ? $chat_id : $this->chat_id;
        $message['message_id'] = $mid;
        $message['inline_query_id'] = $qid;
        $message['cache_time'] = 300;
        $this->Ziyogram('editMessageReplyMarkup', $message);
    }
    public function delete_message($message_id = null, $chat_id = null)
    {
        $message['chat_id'] = (!is_null($chat_id)) ? $chat_id : $this->chat_id;
        $message['message_id'] = $message_id;
        $this->Ziyogram('DeleteMessage', $message);
    }
    public function edit_message($text, $message_id = null, $chat_id = null, $parse_mode = "html")
    {
        $message['text'] = $text;
        $message['chat_id'] = (!is_null($chat_id)) ? $chat_id : $this->chat_id;
        $message['message_id'] = $message_id;
        $message['parse_mode'] = $parse_mode;
        $this->Ziyogram('editMessagetext', $message);
    }
    public function send_document($document, $text, $chat_id = null, $parse_mode = null)
    {
        $message['chat_id'] = (!is_null($chat_id)) ? $chat_id : $this->chat_id;
        $message['document'] = $document;
        $message['caption'] = $text;
        $message['parse_mode'] = $parse_mode;
        $this->Ziyogram('sendDocument', $message);
    }

    public function send_photo($photo, $text, $chat_id = null, $parse_mode = null)
    {
        $message['chat_id'] = $chat_id;
        $message['photo'] = $photo;
        $message['caption'] = $text;
        $message['parse_mode'] = $parse_mode;
        $this->Ziyogram('sendPhoto', $message);
    }

    public function send_audio($audio, $text, $chat_id = null, $parse_mode = null)
    {
        $message['chat_id'] = (!is_null($chat_id)) ? $chat_id : $this->chat_id;
        $message['photo'] = $audio;
        $message['caption'] = $text;
        $message['parse_mode'] = $parse_mode;
        $this->Ziyogram('sendAudio', $message);
    }
    public function Ziyogram($action, $content = [])
    {

        if (!is_null($this->reply_markup)) {
            $content['reply_markup'] = $this->reply_markup;
        }

        if (!is_null($this->reply_markup) && array_key_exists('inline_keyboard', $content['reply_markup']) && count($content['reply_markup']['inline_keyboard']) > 0) {
            unset($content['reply_markup']['keyboard']);
        }

        $url = $this->url . $this->bot_url . $this->token . '/' . $action;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($content));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        $this->request = json_decode($result, TRUE);
        if (!$this->request['ok']) {
            throw new TelegramException($this->request['description']);
        }
        return $this->request;
    }
}
