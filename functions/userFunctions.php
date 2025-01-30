<?php

function getStep($chatId, $filename)
{
    if (!file_exists($filename)) {
        return "FILE NOT FOUND";
    }

    $jsonData = file_get_contents($filename);
    $data = json_decode($jsonData, true);

    foreach ($data['users'] as $user) {
        if ($user['cahtid'] === $chatId) {
            return $user['step'];
        }
    }

    return null;
}