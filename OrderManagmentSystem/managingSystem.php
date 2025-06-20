<?php
require_once('inc/config.inc.php');
require_once('inc/Page.class.php');
require_once('inc/FileUtility.class.php');
require_once('inc/Validate.class.php');

require_once('inc/OrderData.class.php');
require_once('inc/Order.class.php');
require_once('inc/Special.class.php');
require_once('inc/Regular.class.php');

FileUtility::initialize(FILENAME);

$orderData = new OrderData();
$errors = [];
if(isset($_POST['submit'])){
    $errors = Validate::validate();
    if(empty($errors)){
        $orderData->parseWrite();
        FileUtility::write(OrderData::$orderString);
    }
    $notifications = FileUtility::$notifications;
}

$content = FileUtility::read();
$orderData->parseRead($content);


Page::getHeader(Page::$title);
Page::getForm($errors);
Page::getOrders(OrderData::$orders);
Page::getFooter(Page::$developer);