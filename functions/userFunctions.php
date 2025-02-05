<?php

function getStep($chatId, $filename)
{
    if (!file_exists($filename)) {
        return "FILE NOT FOUND";
    }

    $jsonData = file_get_contents($filename);
    $data = json_decode($jsonData, true);

    foreach ($data['users'] as $user) {
        if ($user['chatid'] === $chatId) {
            return $user['step'];
        }
    }

    return null;
}

function setStep($chatId, $newStep, $filename)
{
    if (!file_exists($filename)) {
        return "FILE NOT FOUND";
    }

    $jsonData = file_get_contents($filename);
    $data = json_decode($jsonData, true);

    foreach ($data['users'] as &$user) {
        if ($user['chatid'] === $chatId) {
            $user['step'] = $newStep;
            file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
            return true;
        }
    }

    return false;
}

function addUser($chatId, $username, $filename)
{
    $defaultStep = '1';

    if (!file_exists($filename)) {
        $data = ["users" => []];
    } else {
        $jsonData = file_get_contents($filename);
        $data = json_decode($jsonData, true);
    }

    $newId = count($data['users']) > 0 ? max(array_column($data['users'], 'id')) + 1 : 1;

    $data['users'][] = [
        "id" => $newId,
        "chatid" => $chatId,
        "username" => $username,
        "step" => $defaultStep,
        "requests" => 0,
        "answers" => []
    ];

    file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
    return true;
}

function setAnswer($chatId, $question, $answer, $filename)
{
    if (!file_exists($filename)) {
        return "FILE NOT FOUND";
    }

    $jsonData = file_get_contents($filename);
    $data = json_decode($jsonData, true);

    foreach ($data['users'] as &$user) {
        if ($user['chatid'] === $chatId) {
            $user['answers'] += [$question => $answer];
            file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
            return true;
        }
    }

    return false;
}

function resetAnswer($chatId, $filename)
{
    if (!file_exists($filename)) {
        return "FILE NOT FOUND";
    }

    $jsonData = file_get_contents($filename);
    $data = json_decode($jsonData, true);

    foreach ($data['users'] as &$user) {
        if ($user['chatid'] === $chatId) {
            $user['answers'] = [];
            file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
            return true;
        }
    }

}

function addRequestCount($chatId, $filename)
{
    if (!file_exists($filename)) {
        return "FILE NOT FOUND";
    }

    $jsonData = file_get_contents($filename);
    $data = json_decode($jsonData, true);

    foreach ($data['users'] as &$user) {
        if ($user['chatid'] === $chatId) {
            $user['requests'] += 1;
            file_put_contents($filename, json_encode($data, JSON_PRETTY_PRINT));
            return true;
        }
    }

}