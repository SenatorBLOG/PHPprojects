<?php
// Validate.class.php

class Validate {
    public static function validateEntry(array $data): array {
        $errors = [];
        // Date
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $data['date'] ?? '')) {
            $errors[] = 'Date must be in YYYY-MM-DD format.';
        }
        // Temperature
        $temp = filter_var($data['temperature'] ?? '', FILTER_VALIDATE_FLOAT);
        if ($temp === false || $temp < -50 || $temp > 50) {
            $errors[] = 'Temperature must be between -50 and 50°C.';
        }
        // Humidity
        $hum = filter_var($data['humidity'] ?? '', FILTER_VALIDATE_FLOAT);
        if ($hum === false || $hum < 0 || $hum > 100) {
            $errors[] = 'Humidity must be between 0 and 100%.';
        }
        // Condition
        if (empty(trim($data['condition'] ?? ''))) {
            $errors[] = 'Condition must not be empty.';
        }
        return $errors;
    }

    public static function validateCSV(array $file): array {
        $errors = [];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'CSV upload error.';
        }
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        if (strtolower($ext) !== 'csv') {
            $errors[] = 'File must be a CSV.';
        }
        return $errors;
    }

    public static function validateTXT(array $file): array {
        $errors = [];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'TXT upload error.';
        }
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        if (strtolower($ext) !== 'txt') {
            $errors[] = 'File must be a TXT.';
        }
        return $errors;
    }
}