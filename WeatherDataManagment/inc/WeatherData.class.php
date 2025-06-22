<?php

class WeatherData{
    static $weather = array();
    static $weatherString = '';

    function parseWrite(){
    $date        = $_POST['date']        ?? null;
    $temperature = $_POST['temperature'] ?? null;
    $humidity    = $_POST['humidity']    ?? null;
    $condition   = $_POST['condition']   ?? null;

        self::$weatherString = "\n" . $date . ", " . $temperature . ", " . $humidity . ", " . $condition . ", ";
    }
    function parseRead($fileContent){
        $lines = explode("\n",$fileContent);
        
        for($index = 1; $index < count($lines); $index++){
            
            $columns = explode(",", $lines[$index]);
            $object = null;

            $date        = trim($columns[0] ?? '');
            $temperature = trim($columns[1] ?? '');
            $humidity    = trim($columns[2] ?? '');
            $condition   = trim($columns[3] ?? '');

            $object = new Weather($date, $temperature, $humidity, $condition);
            
            self::$weather [] = $object;
        }
    }


}