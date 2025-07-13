<?php
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "CarDealership");
define("DB_PORT", "3306");

define('LOGFILE', 'log/error_log.txt');
ini_set("log_errors", TRUE);
ini_set('error_log', LOGFILE);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>