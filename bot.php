<?php

$admin = ''; // bu yerga ozingizni chat_id ingizni qo'yasiz

require "Telegram.php";
require "database.php";

$tg = new Telegram();
$db = new Database();

$update = json_decode(file_get_contents('php://input'));

if (isset($update->message)) {
    
    require "message.php";

} elseif (isset($update->callback_query)) {

    require "callback.php";


}
