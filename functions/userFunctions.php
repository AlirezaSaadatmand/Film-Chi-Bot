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


function addUser($chatId, $username, $filename)
{
    $defaultStep = 'home';

    if (!file_exists($filename)) {
        $data = ["users" => []];
    } else {
        $jsonData = file_get_contents($filename);
        $data = json_decode($jsonData, true);
    }

    $newId = count($data['users']) > 0 ? max(array_column($data['users'], 'id')) + 1 : 1;

    $data['users'][] = [
        "id" => $newId,
        "cahtid" => $chatId,
        "username" => $username,
        "step" => $defaultStep
    ];

    file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
    return true;
}
