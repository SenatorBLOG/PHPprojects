<?php

class Order{
    public $type;
    public $custID = '';
    public $amount = 0;
    public $giftWrap = true;
    public $shipping;
    

    function __construct($custID, $amount, $giftWrap, $shipping,){
        $this->custID = $custID;
        $this->amount = $amount;
        $this->giftWrap = $giftWrap;
        $this->shipping = $shipping;
    }
    function calculateTotal(){
        global $shippingCost;
        $totalCost = 0;
        $subTotal = $this->amount * ITEM_COST;
        if($subTotal > 100){
            $subTotal -= $subTotal * DISCOUNT;
        }
        if($this->giftWrap){
            $subTotal += WRAP_COST;
        }
        
        if (isset($shippingCost[$this->shipping])) {
            $subTotal += $shippingCost[$this->shipping];
        }
        $totalCost = $subTotal * (1 + TAX);
        return $totalCost;
    }

}