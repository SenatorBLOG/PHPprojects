<?php

class Regular extends Order{
    public $type = 'Regular';

    function __construct($custID, $amount, $giftWrap, $shipping){
        parent::__construct($custID, $amount, $giftWrap, $shipping);
    }
}