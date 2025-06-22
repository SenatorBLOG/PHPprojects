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
    static function validateCsvRow(array $columns, int $lineNum): bool {
        if (count($columns) !== 4) {
            self::$errors[] = "Line $lineNum: Expected 4 values, found " . count($columns);
            return false;
        }

        [$date, $temperature, $humidity, $condition] = array_map('trim', $columns);

        $d = DateTime::createFromFormat('d-m-Y', $date);
        if (!($d && $d->format('d-m-Y') === $date)) {
            self::$errors[] = "Line $lineNum: Invalid date format ($date), expected d-m-Y";
            return false;
        }

        if (!is_numeric($temperature) || $temperature < -50 || $temperature > 50) {
            self::$errors[] = "Line $lineNum: Temperature ($temperature) must be between -50 and 50";
            return false;
        }

        if (!is_numeric($humidity) || $humidity < 0 || $humidity > 100) {
            self::$errors[] = "Line $lineNum: Humidity ($humidity) must be between 0 and 100";
            return false;
        }

        if (empty($condition)) {
            self::$errors[] = "Line $lineNum: Condition cannot be empty";
            return false;
        }

        return true;
    }
}