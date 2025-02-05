<?php

require_once("../config/config.php");

function bot(string $method, array $params) {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://api.telegram.org/bot' . TOKEN . '/' . $method,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $params
    ]);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);
}

function setWebhook() {
    $result = bot("setWebhook", [
        "url" => "YOUR WEBHOOK URL",
        "drop_pending_updates" => true
    ]);
    return $result;
}

function sendMessage($chat_id, $text, $reply_markup = null) {

    $data = [
        'chat_id' => $chat_id,
        'text' => $text,
        'parse_mode' => 'HTML'
    ];
    if ($reply_markup != null) {
        $data['reply_markup'] = $reply_markup;
    }

    return bot('sendMessage', $data);
}

function sendChatAction($chat_id, $action) {
    return bot('sendChatAction', [
        'chat_id' => $chat_id,
        'action'  => $action
    ]);
}


function debug($data, $reply_markup = null) {
    $result = print_r($data, true);
    if ($reply_markup == null) {
        return sendMessage( ADMIN, $result);
    } else {
        return sendMessage( ADMIN, $result, $reply_markup);
    }
}