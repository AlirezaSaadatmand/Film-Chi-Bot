<?php

function getQuestion($questionNumber, $filename)
{
    if (!file_exists($filename)) {
        return "FILE NOT FOUND";
    }

    $jsonData = file_get_contents($filename);
    $data = json_decode($jsonData, true);

    foreach ($data['permament'] as $question) {
        if ($question == $questionNumber) {
            return $question[$questionNumber];
        }
    }

    foreach ($data['optional'] as $question) {
        if ($question == $questionNumber) {
            return $question[$questionNumber];
        }
    }

    return null;
}