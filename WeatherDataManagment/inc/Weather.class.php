<?php

class Weather{
    public $date;
    public $temperature;
    public $humidity;
    public $condition;

    function __construct($date, $temperature, $humidity, $condition){
        $this->date = $date;
        $this->temperature = $temperature;
        $this->humidity = $humidity;
        $this->condition = $condition;
    }
}