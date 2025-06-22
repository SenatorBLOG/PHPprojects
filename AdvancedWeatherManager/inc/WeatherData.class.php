<?php
// WeatherData.class.php

class WeatherData {
    /** @return WeatherEntry[] */
    public static function parseRead(): array {
        $entries = [];
        if (!file_exists(WEATHER_DATA)) {
            return $entries;
        }
        if (($handle = fopen(WEATHER_DATA, 'r')) !== false) {
            while (($row = fgetcsv($handle)) !== false) {
                // Skip lines with less than 4 columns
                if (count($row) < 4) continue;
                // Safely assign values with default empty strings
                $date = trim($row[0] ?? '');
                $temp = trim($row[1] ?? '');
                $hum = trim($row[2] ?? '');
                $cond = trim($row[3] ?? '');
                // Skip if any field is empty after trimming
                if (empty($date) || empty($temp) || empty($hum) || empty($cond)) continue;
                $entries[] = new WeatherEntry($date, (float)$temp, (float)$hum, $cond);
            }
            fclose($handle);
        }
        return $entries;
    }

    // Other methods remain unchanged for now
    public static function parseWrite(WeatherEntry $entry): bool {
        return FileUtility::append(WEATHER_DATA, [
            $entry->date,
            $entry->temperature,
            $entry->humidity,
            $entry->condition
        ]);
    }

    public static function appendFromCSV(string $uploadedPath): bool {
        if (!file_exists($uploadedPath)) return false;
        if (($in = fopen($uploadedPath, 'r')) === false) return false;
        // Skip header
        fgetcsv($in);
        while (($row = fgetcsv($in)) !== false) {
            if (count($row) < 4) continue;
            FileUtility::append(WEATHER_DATA, $row);
        }
        fclose($in);
        return true;
    }
}