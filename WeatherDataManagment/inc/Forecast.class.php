<?php
class Forecast {
    static function readForecast($filename) {
        try {
            if (file_exists($filename)) {
                return file_get_contents($filename);
            }
            return '';
        } catch (Exception $e) {
            FileUtility::$notifications[] = "Error reading forecast: " . $e->getMessage();
            return '';
        }
    }

    static function writeForecast($uploadedTXT) {
        if (!file_exists($uploadedTXT)) {
            FileUtility::$notifications[] = "Error: Uploaded TXT file not found.";
            return false;
        }

        $content = file_get_contents($uploadedTXT);
        FileUtility::$currentFile = REPOSITORY . 'forecast.txt';
        FileUtility::write($content);
        return true;
    }
}