<?php

class Validate{ 
    static $errors = array();

    static function validate(){
        $validType = trim($_POST['order_type'] ?? '');
        if(empty($validType)){
            self::$errors['Type Error'] = "Please select a type"; 
        }
        $validCustID = trim($_POST['cust_id'] ?? '');
        if(empty($validCustID)){
            self::$errors['ID Error'] = "Please enter Customer ID";
        } else if (!preg_match('/^C\d{3}[A-Z]$/', $validCustID)){
            self::$errors['ID Error'] = "ID must follow the format C000A";
        }
        $validAmount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_INT,[ 
            "options" => ["min_range" => 1, "max_range" => 10]
        ]);
        if($validAmount === false || $validAmount === null){
            self::$errors ['Amount Error'] = "Please enter amount from 1 to 10";
        }
        
        if (!isset($_POST['shipping']) || empty($_POST['shipping'])) {
            self::$errors['Shipping Error'] = "Please select a shipping option";
        }
        return self::$errors;
    }
}