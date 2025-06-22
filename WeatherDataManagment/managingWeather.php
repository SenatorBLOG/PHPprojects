<?php
require_once('inc/config.inc.php');
require_once('inc/Page.class.php');
require_once('inc/FileUtility.class.php');
require_once('inc/Validate.class.php');

require_once('inc/WeatherData.class.php');
require_once('inc/Weather.class.php');

FileUtility::initialize(FILENAME);

$weatherData = new WeatherData();
$errors = [];
$notifications = [];
$csvNotifications = [];
$txtNotifications = [];

if(isset($_POST['submit_entry'])){
    $errors = Validate::validate();
    if(empty($errors)){
        $weatherData -> parseWrite();
        FileUtility::write(WeatherData::$weatherString);
    }
    $notifications = FileUtility::$notifications;
}


if (isset($_POST['submit_csv'])) {
    $fileCsv = FileUtility::upload('csv_file', ['text/csv', 'text/plain']);
    if (!empty($fileCsv)) {
        $content = file_get_contents($fileCsv);
        $lines = explode("\n", $content);
        $csvData = [];
        foreach ($lines as $index => $line) {
            $line = trim($line);
            if (empty($line))
                continue;
            $columns = str_getcsv($line);
            if (Validate::validateCsvRow($columns, $index + 1)) {
                $csvData[] = $line; 
            }
        }
        if (!empty($csvData)) {
            FileUtility::$currentFile = FILENAME;
            FileUtility::write(implode("\n", $csvData) . "\n");
        }
    }
    $csvNotifications = FileUtility::$notifications;
    FileUtility::$notifications = []; // сбросим
}

if (isset($_POST['submit_txt'])) {
    $fileTxt = FileUtility::upload('txt_file', ['text/plain']);
    if (!empty($fileTxt)) {
        $content = file_get_contents($fileTxt);
        $lines = explode("\n", $content);
        $txtData = [];
        for ($i = 1; $i < count($lines); $i++) {
            $line = trim($lines[$i]);
            if (empty($line)) {
                continue;
            }

            $columns = str_getcsv($line);
            if (Validate::validateCsvRow($columns, $i + 1)) {
                $txtData[] = $line;
            }
        }
        if (!empty($txtData)) {
            FileUtility::$currentFile = FILENAME;
            FileUtility::write(implode("\n", $txtData) . "\n");
        }
    }
    $txtNotifications = FileUtility::$notifications;
    FileUtility::$notifications = []; // сбросим
}


if (isset($_POST['delete_file'])) {
    $target = REPOSITORY . basename($_POST['delete_file']);
    if (file_exists($target)) {
        unlink($target);
        FileUtility::$notifications[] = "Success: File deleted.";
    } else {
        FileUtility::$notifications[] = "Error: File not found.";
    }
}

$content = FileUtility::read();
if ($content !== false) {
    $weatherData->parseRead($content);
}
Page::getHeader(Page::$title);
Page::getForm($errors);
Page::uploadCsv($csvNotifications);
Page::uploadTxt($txtNotifications);
Page::listUploadedFiles(REPOSITORY);
Page::getWeatherList(WeatherData::$weather);
Page::getFooter(Page::$developer);