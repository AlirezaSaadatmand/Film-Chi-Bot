<?php

if (array_key_exists('message', $input)) {
    $firstName = $input['message']['from']['first_name'];
    $fromId = $input['message']['from']['id'];
    $text = $input['message']['text'];
}