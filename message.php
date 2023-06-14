<?php

$message = $update->message;
$text = $message->text ?? null;
$cid = $message->chat->id ?? null;
$firstname = $message->from->first_name ?? null;
$lastname = $message->from->last_name ?? null;

// $user_data = $db->getUser($cid);
if ($message->text){
    if ($text == "/start") {
        // Bu yerda agar foydalanuvchi yoq bo'lsa uni malumotlar bazasiga qo'shadi.
        // if ($user_data['id'] > 0) {
        //     $tg->send_message("Assalomu alaykum", $cid, 'markdown');
        // } else {
        //     $tg->send_message("Assalomu alaykum, Botga hush kelibsiz", $cid);

        //     //bu kod orqali foydalanuvchi malumotlar bazasiga qo'shiladi
        //     $db->addUser($firstname . " " . $lastname, $cid); 
        // }
        $tg->set_chatId('@ziyodev')
//    ->send_chatAction('typing')
   ->send_message('Telegram botdan salom');
    }

//     //// ----------- Photo message ----------
// }elseif ($message->photo){
    
//     $photo_id = $message->photo->file_id;
//     $caption = $message->photo->caption;

//     $tg->send_photo($photo_id, $caption, $cid);

//     //// ----------- Video message ----------
// }elseif ($message->video){
//     $video_id = $message->video->file_id;
//     $caption = $message->video->caption;
//     $tg->send_video($video_id, $caption, $cid);

//     //// ----------- Audio message ----------
// }elseif ($message->audio){
//     $audio_id = $message->audio->file_id;
//     $caption = $message->audio->caption;
//     $tg->send_audio($audio_id, $caption, $cid);
}