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
    $greetingText = "🎬 سلام! خوش اومدی! 🍿
بذار کمکت کنم یه فیلم یا سریال عالی پیدا کنی! 🎥✨
فقط به چند سوال کوتاه جواب بده تا بهترین پیشنهاد رو بهت بدم. 🎭🎞️

🔥 بزن بریم! 🚀";

    sendMessage($chatId, $greetingText);
} else {
    sendMessage($chatId, getQuestion($text, $questionsDataFile));
}



// $response = chatBot($text);

// sendMessage($fromId , $response);