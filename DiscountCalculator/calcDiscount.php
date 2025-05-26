<?php
define("SALE",0.88);
$cart = [
    ['name' => 'banana', 'price' => 0.2, 'quantity' => 0],
    ['name' => 'apple', 'price' => 0.5, 'quantity' => 0],
    ['name' => 'orange', 'price' => 0.3, 'quantity' => 0]
];

function inputQuantity(&$cart){
    foreach($cart as $item){
        $name = $item['name'];
        echo "Enter a quantity of the {$name} product: \n";
        $qty = stream_get_line(STDIN,1024,PHP_EOL);
        if($qty < 0 ){
            echo "Quantity cannot be negative. Setting to 0.\n";
            $qty = 0;
        }
        $item['quantity'] = $qty;
    }
};
function calcTotal($cart){
    $total = 0;
    foreach($cart as $item){
        $total += $item['price'] * $item['quantity'];
        $totalArr = ['total' => $total];
    }
    array_push($cart, $totalArr);
    return $total;
};
function printCart($cart){
    foreach($cart as $item){
        printf("%-10s %-10s %-10s %-10s",$item['name'],$item['price'],$item['quantity'],$item['total']);
    }
};

function applyDiscount($total){
    if($total > 30){
        $discount = $total * SALE;
        echo "The discount was applied of 12%";
        echo "Total price after discount: " . $discount;
    } else {
        echo "The discount wasn't applied";
    }

};

inputQuantity($cart);
$total = calcTotal($cart);
printCart($cart);
applyDiscount($total);