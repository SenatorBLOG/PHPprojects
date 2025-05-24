<?php
require_once("inc/config.inc.php");
require_once("inc/function.inc.php");

$count = 0;
getHeader();
do{
    $count++;
    echo "\nOrder record: {$count}\n\n";
    $orderData = generateOrder();
    calculateAndPrintOrder($orderData,$itemPrice,$discountThreshold);

    echo "\nDo you want to add another record of order? (Y/N)"; 
    $input = trim(stream_get_line(STDIN, 1024, PHP_EOL));
} while(strtolower($input) === 'y');
echo "\nYou have generated {$count} batch(es) of customer record(s). Good bye!";

