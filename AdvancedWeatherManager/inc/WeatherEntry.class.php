<?php
// WeatherEntry.class.php

class WeatherEntry {
    public string $date;
    public float $temperature;
    public float $humidity;
    public string $condition;

    public function __construct(string $date, float $temperature, float $humidity, string $condition) {
        $this->date = $date;
        $this->temperature = $temperature;
        $this->humidity = $humidity;
        $this->condition = $condition;
    }
}