<?php
// Defining available tickets function
$prices = [
    ['package' => 'Standard', 'price' => 10, 'quantity' => 0 ],
    ['package' => 'Premium', 'price' => 15, 'quantity' => 0],
    ['package' => 'VIP', 'price' => 25, 'quantity' => 0]
];

//Function to ask user for tickets quantity
function inputTicketsQty(&$prices){
    foreach($prices as &$item){
        echo "Enter amount of {$item['package']} tickets: \n";
        $quantity = (int)stream_get_line(STDIN,1024,PHP_EOL);
        if($quantity < 0){
            echo "Quantity must be positive. Setting quantity to 0";
            $quantity = 0;
        }
        $item['quantity'] = $quantity;
    }
}

// Function to calculate the total price
function calcTotalPrice($prices){
    $total = 0;
    foreach($prices as $item){
        $total += $item['price'] * $item['quantity'];
    }
    return $total;
}

//Function to display ticket information
function displayTicket($prices){
    echo "\nMovie ticket\n";
    foreach($prices as $item){
        echo "{$item['package']}: {$item['quantity']} x \${$item['price']} = \$".($item['price'] * $item['quantity'])."\n";
    }
   
}

//Function to define weather if discout was applied or not
function applyDiscount($finalTotal){
    if ($finalTotal > 50) {
        $afterDiscount = $finalTotal * 0.90;
        echo "The total amount before discount: {$finalTotal}\n";
        echo "The total amount after 10% discount: {$afterDiscount}\n";
    } else {
        echo "The total amount before discount: {$finalTotal}\n";
        echo "The discount is not applying.\n";
    }
    
}


inputTicketsQty($prices);
$finalTotal = calcTotalPrice($prices);
displayTicket($prices);
applyDiscount($finalTotal);
