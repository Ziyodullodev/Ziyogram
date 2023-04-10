<?php

$qid = $update->callback_query->id ?? null; 
$data = $update->callback_query->data ?? null;
$cid = $update->callback_query->message->chat->id ?? null;
$mid = $update->callback_query->message->message_id ?? null;


if ($data){
    $tg->send_message("Callback query", $cid);

}