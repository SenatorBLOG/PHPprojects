<?php
require_once('inc/config.inc.php');
class Order{
    public $custID = '';
    public $amount = 0;
    public $giftWrap = true;
    public $shipping;
    public $shippingCost;

    function __construct($custID, $amount, $giftWrap, $shipping){
        $this->custID = $custID;
        $this->amount = $amount;
        $this->giftWrap = $giftWrap;
        $this->shipping = $shipping;
    }
    function calculateTotal(){
        $totalCost = 0;
        $subTotal = $this->amount * ITEM_COST;
        if($subTotal > 100){
            $subTotal -= $subTotal * DISCOUNT;
        }
        if($this->giftWrap){
            $subTotal += WRAP_COST;
        }
        if(isset($this->shippingCost[$this->shippingCost])){
            $subTotal += $this->shippingCost[$this->shipping];
        }
        


    }

}