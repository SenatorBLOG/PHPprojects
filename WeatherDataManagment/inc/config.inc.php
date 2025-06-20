<?php

date_default_timezone_set("America/Vancouver");

define("LOGFILE","log/error_log.txt");
  
// setting error logging to be active 
ini_set("log_errors", TRUE);
  
// setting the logging file in php.ini 
ini_set("error_log", LOGFILE);

// for file operation
define("REPOSITORY","data/");
define("FILEDATA","weatherEntry.txt");
define("FILENAME",REPOSITORY.FILEDATA);

//debugging in browser
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


