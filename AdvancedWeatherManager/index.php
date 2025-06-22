<?php
// index.php

// 1) Turn on errors for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2) Includes
require_once 'inc/config.inc.php';
require_once 'inc/FileUtility.class.php';
require_once 'inc/Validate.class.php';
require_once 'inc/WeatherEntry.class.php';
require_once 'inc/WeatherData.class.php';
require_once 'inc/Forecast.class.php';
require_once 'inc/Page.class.php';

// 3) Initialize containers
$errors  = ['entry' => [], 'csv' => [], 'txt' => []];
$success = [];

// 4) Handle “Add Entry”
if (isset($_POST['submit_entry'])) {
    $entryErrors = Validate::validateEntry($_POST);
    if (empty($entryErrors)) {
        $entry = new WeatherEntry(
            $_POST['date'],
            (float)$_POST['temperature'],
            (float)$_POST['humidity'],
            trim($_POST['condition'])
        );
        if (WeatherData::parseWrite($entry)) {
            $success['entry'] = 'Entry added successfully.';
        } else {
            $errors['entry'][] = 'Failed to save entry.';
        }
    } else {
        $errors['entry'] = $entryErrors;
    }
}

// 5) Handle “Upload CSV”
if (isset($_POST['submit_csv'])) {
    $csvFile   = $_FILES['csv_file'] ?? null;
    $csvErrors = Validate::validateCSV($csvFile);
    if (empty($csvErrors) && WeatherData::appendFromCSV($csvFile['tmp_name'])) {
        $success['csv'] = 'CSV data appended successfully.';
    } else {
        $errors['csv'] = $csvErrors ?: ['Failed to append CSV data.'];
    }
}

// 6) Handle “Upload TXT”
if (isset($_POST['submit_txt'])) {
    $txtFile   = $_FILES['txt_file'] ?? null;
    $txtErrors = Validate::validateTXT($txtFile);
    if (empty($txtErrors) && Forecast::writeForecast(file_get_contents($txtFile['tmp_name']))) {
        $success['txt'] = 'Forecast updated successfully.';
    } else {
        $errors['txt'] = $txtErrors ?: ['Failed to update forecast.'];
    }
}

// 7) Build messages arrays for the Page methods
$messagesCsv = $success['csv'] ?? $errors['csv'] ?? [];
$messagesCsv = is_array($messagesCsv) ? $messagesCsv : [$messagesCsv];
$messagesTxt = $success['txt'] ?? $errors['txt'] ?? [];
$messagesTxt = is_array($messagesTxt) ? $messagesTxt : [$messagesTxt];

// 8) Read all weather entries + forecast
$weatherEntries = WeatherData::parseRead();
$forecast       = Forecast::readForecast();

// 9) Compute statistics
$totalEntries = count($weatherEntries);
$avgTemperature = $totalEntries
    ? array_sum(array_map(fn($e) => $e->temperature, $weatherEntries)) / $totalEntries
    : 0;
$avgHumidity = $totalEntries
    ? array_sum(array_map(fn($e) => $e->humidity, $weatherEntries)) / $totalEntries
    : 0;
$conditions = array_map(fn($e) => $e->condition, $weatherEntries);
$mostCommonCondition = $conditions
    ? array_search(
        max($freq = array_count_values($conditions)),
        $freq
      )
    : 'N/A';

// 10) Package stats for the Page
$stats = [
    'totalEntries'    => $totalEntries,
    'averageTemp'     => $avgTemperature,
    'averageHumidity' => $avgHumidity,
    'commonCondition' => $mostCommonCondition
];

// 11) Render with Page methods
Page::header();
    Page::formAddEntry($errors['entry']);
    Page::formUploadCsv($messagesCsv);
    Page::formUploadTxt($messagesTxt);
    Page::listUploadedFiles(REPOSITORY);
    Page::listWeatherEntries($weatherEntries);
    Page::showForecast($forecast);
    Page::showStatistics($stats);
Page::footer();
