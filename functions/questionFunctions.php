<?php

function getQuestion($questionNumber, $filename)
{
    if (!file_exists($filename)) {
        return "FILE NOT FOUND";
    }

    $questionNumber = "q" . $questionNumber;

    $jsonData = file_get_contents($filename);
    $data = json_decode($jsonData, true);

    foreach ($data["permanent"] as $question) {
        if (array_key_exists($questionNumber, $question)) {
            return $question[$questionNumber];
        }
    }

    foreach ($data["optional"] as $question) {
        if (array_key_exists($questionNumber, $question)) {
            return $question[$questionNumber];
        }
    }

    return null;
}