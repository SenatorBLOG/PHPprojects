<?php

function getHeader(){
    echo "----------------------------------------------------------------------------------------------\n\n";
    echo "          Product order calculator app by " . APP_DEVELOPER . "  (" . APP_ID . ")             \n\n";
    echo "----------------------------------------------------------------------------------------------\n\n";
}
// function for populating the array of orders data
function generateOrder(){
    $orderData =[];
    for($i=1;$i<=4;$i++){
        $orderId = "order_" . $i;
        $amount =[
            rand( MIN_AMOUNT, MAX_AMOUNT),
            rand( MIN_AMOUNT, MAX_AMOUNT),
            rand( MIN_AMOUNT, MAX_AMOUNT)
        ];
        $order = [
            'id' => $orderId,
            'amount' => $amount
        ];
        array_push($orderData, $order);
    }
    return $orderData;
}
function getSubTotal($amount, $price){
    $subTotal = 0;
    for ($i = 0; $i < count($amount); $i++) {
        $subTotal += $amount[$i] * $price[$i];
    }
    return $subTotal;
}
function getDiscountedPercentage($subTotal, $discountThreshold){
    $returnDiscount = 0;
    foreach($discountThreshold as $key => $discount){
        if($subTotal >= $key) {
            $returnDiscount = $discount;
        } else {
            break;
        }
    }
    return $returnDiscount;               
}
function calculateAndPrintOrder($orderData, $price, $discountThreshold){
    printf("%-10s %-10s %-10s %-10s %-10s %-10s\n", "Order","Product A","Product B","Product C","Discount", "Sub Total");
    foreach($orderData as $order){
        $amount = $order['amount'];
        $id = $order['id'];
        $subTotal = getSubTotal($order['amount'],$price);
        $discountPercentage = getDiscountedPercentage($subTotal, $discountThreshold);
        $discounted = $subTotal * (1 - $discountPercentage);
        $finalTotal = $discounted * (1 + TAX_RATE);

        printf("%-10s %-10d %-10d %-10d %-10s %-10s\n", $id, $amount[0],
        $amount[1],$amount[2],($discountPercentage  * 100)."%","$".number_format($finalTotal,2));
    }
    
}

