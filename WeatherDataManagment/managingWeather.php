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
if(isset($_POST['submit_entry'])){
    $errors = Validate::validate();
    if(empty($errors)){
        $weatherData -> parseWrite();
        FileUtility::write(WeatherData::$weatherString);
    }
    $notifications = FileUtility::$notifications;
}
if(isset($_POST['submit_csv'])){
    $fileCsv = FileUtility::upload('csv_file', ['text/csv']);
    if(!empty($fileCsv)){
        FileUtility::$currentFile = $fileCsv;
        $weatherData -> parseWrite();
        FileUtility::write($weatherData -> weatherString);
    }
    $notifications = FileUtility::$notifications;
}

if(isset($_POST['submit_txt'])){
    $fileTxt = FileUtility::upload('txt_file', ['text/plain']);
    if(!empty($fileTxt)){
        FileUtility::$currentFile = $fileTxt;
        $weatherData -> parseWrite();
        FileUtility::write($weatherData -> weatherString);
    }
    $notifications = FileUtility::$notifications;
}

$content = FileUtility::read();
$weatherData->parseRead($content);

Page::getHeader(Page::$title);
Page::getForm($errors);
Page::uploadCsv($errors);
Page::uploadTxt($errors);
Page::getWeatherList(WeatherData::$weather);
// Page::getForecast();
// Page::getStatistics();
Page::getFooter(Page::$developer);