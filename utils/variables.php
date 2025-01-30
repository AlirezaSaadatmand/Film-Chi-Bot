<?php

if (array_key_exists('message', $input)) {
    $username = $input['message']['from']['first_name'];
    $chatId = $input['message']['from']['id'];
    $text = $input['message']['text'];
}