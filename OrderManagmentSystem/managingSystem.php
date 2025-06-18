<?php
require_once('inc/config.inc.php');
require_once('inc/Page.class.php');


Page::getHeader(Page::$title);
Page::getForm();
Page::getOrders();
Page::getFooter(Page::$developer);