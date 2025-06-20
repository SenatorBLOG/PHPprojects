<?php

class OrderData{
    static $orders = array();
    static $orderString = '';

    function parseRead($fileContent){
        $lines = explode("\n",$fileContent);

        for($index = 1; $index < count($lines); $index++){
            $columns = explode(",", $lines[$index]);
            $object = null;

            $type = trim($columns[0]);
            $custID = trim($columns[1]);
            $amount = trim($columns[2]);
            $giftWrap  = trim($columns[3]);
            $shipping = trim($columns[4]);

            switch($type){
                case "regular":
                    $object = new Regular($custID, $amount, $giftWrap, $shipping);
                    break;
                case "special":
                    $object = new Special($custID, $amount, $giftWrap, $shipping);
                    break;
                default:
                    $object = new Order($custID, $amount, $giftWrap, $shipping);
                    $object->type = "Unknown";
                    break;
            }
            self::$orders [] = $object;
        }
    }
    function parseWrite(){
        $type = $_POST['order_type'];
        $custID = $_POST['cust_id'];
        $amount = $_POST['amount'];
        $giftWrap  = $_POST['gift_wrap']; 
        $shipping = $_POST['shipping'];

        self::$orderString = "\n" . $type . ", " . $custID . ", " . $amount . ", " . $giftWrap . ", " . $shipping . ", ";
    }
}