<?php

class Validate{ 
    static $errors = array();

    static function validate(){
        $validDate = trim($_POST['date'] ?? '');
        if(!(($d = DateTime::createFromFormat('d-m-Y', $validDate)) && 
        $d->format('d-m-Y') === $validDate)){
            self::$errors['Date Error'] = "Please enter a date in format:"; 
        }
        $validTemperature = filter_input(INPUT_POST, 'temperature', FILTER_VALIDATE_INT,[ 
            "options" => ["min_range" => -50, "max_range" => 50]
        ]);
        if($validTemperature === false || $validTemperature === null){
            self::$errors ['Temperature Error'] = "Please enter temperature from -50 to +50 (°C)";
        }

        $validHumidity = filter_input(INPUT_POST, 'humidity', FILTER_VALIDATE_INT,[ 
            "options" => ["min_range" => 0, "max_range" => 100]
        ]);
        if($validHumidity === false || $validHumidity === null){
            self::$errors ['Humidity Error'] = "Please enter humidity from 0 to 100 (%)";
        }
        $validCondition = trim($_POST['condition'] ?? '');
        if (empty($validCondition)) {
            self::$errors['Condition Error'] = "Please enter any condition";
        }
        
        return self::$errors;
    }
}