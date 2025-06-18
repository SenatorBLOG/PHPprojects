<?php

class Special extends Order{
    public $type =  'Special';

    function __construct($custID, $amount, $giftWrap, $shipping){
        parent::__construct($custID, $amount, $giftWrap, $shipping);
    }
}