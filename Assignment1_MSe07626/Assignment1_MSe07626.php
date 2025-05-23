<?php
require_once("inc/config.inc.php");
require_once("inc/function.inc.php");

$count = 0;
do{
    getHeader();
    $count++;
    global $itemPrice;
    global $discountThreshold;
    echo "Order record: {$count}\n";
    $orderData = generateOrder();
    calculateAndPrintOrder($orderData,$itemPrice,$discountThreshold);

    echo "Do you want to add another record of order? (Y/N)"; 
    $input = trim(stream_get_line(STDIN, 1024, PHP_EOL));
} while(strtolower($input) === 'y');

