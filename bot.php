<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set("Asia/Tehran");


$input = json_decode(file_get_contents("php://input"), true);

require("utils/variables.php");
require("functions/botFunctions.php");
require("functions/requestFunctions.php");
require("functions/userFunctions.php");
require("functions/questionFunctions.php");

$userDataFile = __DIR__ . "/database/users.json";
$questionsDataFile = __DIR__ . "/database/questions.json";

$step = getStep($chatId, $userDataFile);

if (!$step) {
    addUser($chatId, $username, $userDataFile);
}

if ($text == "/start") {
    $greetingText = "🎬 سلام {$username} خوش اومدی! 🍿
بذار کمکت کنم یه فیلم یا سریال عالی پیدا کنی! 🎥✨
فقط به چند سوال کوتاه جواب بده تا بهترین پیشنهاد رو بهت بدم. 🎭🎞️

🔥 بزن بریم! 🚀";

    sendMessage($chatId, $greetingText);

    sendMessage($chatId, getQuestion("1", $questionsDataFile));
    setStep($chatId, "2", $userDataFile);
    die;
}

if ($step == "2") {
    setAnswer($chatId, "1", $text, $userDataFile);
    sendMessage($chatId, getQuestion("2", $questionsDataFile));
    setStep($chatId, "3", $userDataFile);
    die;
}

if ($step == "3") {
    setAnswer($chatId, "2", $text, $userDataFile);
    sendMessage($chatId, getQuestion("3", $questionsDataFile));
    setStep($chatId, "4", $userDataFile);
    die;
}

if ($step == "4") {
    setAnswer($chatId, "3", $text, $userDataFile);
    sendMessage($chatId, getQuestion("4", $questionsDataFile));
    setStep($chatId, "5", $userDataFile);
    die;
}
