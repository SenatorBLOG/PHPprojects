<?php

require_once "inc/config.inc.php";
require_once "inc/functions.inc.php";

$hours = inputValues();
tierConvert($hours,$timeSheet);
$total = totalWage($timeSheet);
printRes($total);