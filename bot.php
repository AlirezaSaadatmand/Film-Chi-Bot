<?php

$input = json_decode(file_get_contents("php://input") , true);

require_once("./config/config.php");
require_once("./utils.variables.php");
require_once("./functions/botFunctions.php");
require_once("./functions/requestFunctions.php");

