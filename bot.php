<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set("Asia/Tehran");


$input = json_decode(file_get_contents("php://input") , true);

require("utils/variables.php");
require("functions/botFunctions.php");
require("functions/requestFunctions.php");

sendMessage($fromId , "hello world");