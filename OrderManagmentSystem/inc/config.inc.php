<?php

date_default_timezone_set("America/Vancouver");

define("LOGFILE","log/error_log.txt");
  
// setting error logging to be active 
ini_set("log_errors", TRUE);
  
// setting the logging file in php.ini 
ini_set("error_log", LOGFILE);

// for file operation
define("REPOSITORY","data/");
define("FILEDATA","orders.txt");
define("FILENAME",REPOSITORY.FILEDATA);

//debugging in browser
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


define("ITEM_COST",25);
define("WRAP_COST",10);
define("DISCOUNT",0.15);
define("TAX",0.12);

$shippingCost = ['regular' => 6, 'express' => 15, 'premium' => 25];
