<?php
// Forecast.class.php


class Forecast {
    public static function readForecast(): string {
        return file_exists(FORECAST_FILE)
            ? file_get_contents(FORECAST_FILE)
            : '';
    }

    public static function writeForecast(string $content): bool {
        return FileUtility::write(FORECAST_FILE, $content);
    }
}