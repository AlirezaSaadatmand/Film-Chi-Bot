<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set("Asia/Tehran");


$input = json_decode(file_get_contents("php://input"), true);

require("utils/variables.php");
require("functions/botFunctions.php");
require("functions/userFunctions.php");
require("functions/questionFunctions.php");
require("functions/requestFunctions.php");

$userDataFile = __DIR__ . "/database/users.json";
$questionsDataFile = __DIR__ . "/database/questions.json";

$step = getStep($chatId, $userDataFile);

if (!$step) {
    addUser($chatId, $username, $userDataFile);
}

if ($text == "/start") {
    resetAnswer($chatId, $userDataFile);
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

if ($step == "5") {
    setAnswer($chatId, "4", $text, $userDataFile);
    sendMessage($chatId, getQuestion("5", $questionsDataFile));
    setStep($chatId, "result", $userDataFile);

    die;
}

if ($step == "result") {
    setAnswer($chatId, "4", $text, $userDataFile);

    $response = makeChat($chatId, $userDataFile, $questionsDataFile);

    if ($response["status"] == 200) {
        $filmTexts = [];

        $filmsData = $response["result"][0];

        $films = array_filter(explode("---", $filmsData));

        foreach ($films as $film) {
            $film = trim($film);
            if (empty($film))
                continue;

            preg_match('/Title:\s*(.*?)\nDescription:\s*(.*?)\nIMDb:\s*\[(.*?)\]/s', $film, $matches);

            if (!empty($matches)) {
                $title = trim($matches[1]);
                $description = trim($matches[2]);
                $imdb = trim($matches[3]);

                $filmText = "🎬 *$title*\n📖 $description\n🔗$imdb";

                $filmTexts[] = $filmText;
            }
        }
        foreach ($filmTexts as $text) {
            sendMessage($chatId, $text);
        }
    }
    setStep($chatId, "done", $userDataFile);
    die;
}

if ($step == "done") {
    sendMessage($chatId, "دوباره /start بزن");
}