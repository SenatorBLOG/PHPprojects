<?php
// config.inc.php

date_default_timezone_set("America/Vancouver");

define("LOGFILE","log/error_log.txt");
  
// setting error logging to be active 
ini_set("log_errors", TRUE);
  
// setting the logging file in php.ini 
ini_set("error_log", LOGFILE);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define('REPOSITORY', dirname(__DIR__) . '/data/');
define('WEATHER_DATA', REPOSITORY . 'weather_data.csv');
define('FORECAST_FILE', REPOSITORY . 'forecast.txt');

if (!file_exists(REPOSITORY)) {
    mkdir(REPOSITORY, 0755, true);
}