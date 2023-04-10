<?php

class Telegram {
    private $token = ''; // bu yerga o'zingizni telegram bot tokeningizni joylashtirasiz

    function Ziyogram($method, $datas = [])
    {
        $url = "https://api.telegram.org/bot" . $this->token . "/" . $method;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
        $res = curl_exec($ch);
        if (curl_error($ch)) {
            var_dump(curl_error($ch));
        } else {
            return json_decode($res);
        }
    }


    public function send_message($text, $chat_id = null,$parse_mode = null, $key=null){
        $params['text'] = $text;
        $params['chat_id'] = $chat_id;
        $params['parse_mode'] = $parse_mode;
        $params['reply_markup'] = $key;
        $this->Ziyogram('sendMessage', $params);
    }   

    public function send_answer($text, $chat_id = null, $callquery, $parse_mode = null, $alert = true){
        $params['text'] = $text;
        $params['chat_id'] = $chat_id;
        $params['callback_query_id'] = $callquery;
        $params['show_alert'] = $alert;
        $this->Ziyogram('answerCallbackQuery', $params);
    }

    public function editMessageReplyMarkup($chat_id, $mid, $qid, $key){
        $params['chat_id'] = $chat_id;
        $params['message_id'] = $mid;
        $params['inline_query_id'] = $qid;
        $params['reply_markup'] = $key;
        $params['cache_time'] = 300;
        $this->Ziyogram('editMessageReplyMarkup', $params);
    }

    public function delete_message($chat_id = null, $message_id = null){
        $params['chat_id'] = $chat_id;
        $params['message_id'] = $message_id;
        $this->Ziyogram('DeleteMessage', $params);
        
    }
    
    public function edit_message($text, $chat_id = null, $message_id = null, $parse_mode="html"){
        $params['text'] = $text;
        $params['chat_id'] = $chat_id;
        $params['message_id'] = $message_id;
        $params['parse_mode'] = $parse_mode;
        $this->Ziyogram('editMessagetext', $params);
        }

    public function send_document($document, $text, $chat_id = null, $parse_mode = null, $key=null){
        $params['chat_id'] = $chat_id;
        $params['document'] = $document;
        $params['caption'] = $text;
        $params['parse_mode'] = $parse_mode;
        $params['reply_markup'] = $key;
        $this->Ziyogram('sendDocument', $params);
    }  

    public function send_photo($photo, $text, $chat_id = null, $parse_mode = null, $key=null){
        $params['chat_id'] = $chat_id;
        $params['photo'] = $photo;
        $params['caption'] = $text;
        $params['parse_mode'] = $parse_mode;
        $params['reply_markup'] = $key;
        $this->Ziyogram('sendPhoto', $params);
    }  

    public function send_audio($audio, $text, $chat_id = null, $parse_mode = null, $key=null){
        $params['chat_id'] = $chat_id;
        $params['photo'] = $audio;
        $params['caption'] = $text;
        $params['parse_mode'] = $parse_mode;
        $params['reply_markup'] = $key;
        $this->Ziyogram('sendAudio', $params);
    }  

    public function setWebhook($url) {
        $params['url'] = $url;

        $this->Ziyogram('setWebhook', $params);
    }

}