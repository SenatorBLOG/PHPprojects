<?php

function inputValues(){
    echo "Please enter amount of total hours worked: ";
    return stream_get_line(STDIN,1024,PHP_EOL);
}

function tierConvert($hours,&$timeSheet){

        if($hours < 40){
            $timeSheet['hours'] = $hours;
        } elseif ($hours >= 40 || $hours <50){
            $timeSheet['hours'] = 40;
            $timeSheet['tier2']['hours'] = $hours - 40 ;
            
        } else {
            $timeSheet['hours'] = 40;
            $timeSheet['tier2']['hours'] = 50 ;
            $timeSheet['tier3']['hours'] = $hours - 50;
        }
    
}
function totalWage($timeSheet){
    $total = 0;
    foreach($timeSheet as $item){
        $total += $item['salary'] * $item['hours'];
    }
    return $total;
}
function printRes($total){
    echo "Total Salary: \$" . number_format($total,2);
}

