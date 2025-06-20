<?php

class Page{

    static $title = "Order Management System";
    static $developer = "Mikhail Senatorov";

    static function getHeader($title){
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Order Management System</title>
            <link rel="stylesheet" href="css/styles.css">
        </head>
        <body>
        <header>
            <h1><?php echo "$title" ?></h1>
        </header>
        <main>
        <?php
    }

    static function getForm($errors = []){
        ?>
        <section id="add-order">
            <h2>Add New Order</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <label for="order_type">Order Type:</label>
                <select id="order_type" name="order_type">
                    <option value="regular">Regular</option>
                    <option value="special">Special</option>
                </select><br>
                <label for="cust_id">Customer ID:</label>
                <input type="text" id="cust_id" name="cust_id"><br>
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount"><br>
                <label for="gift_wrap">Gift Wrap:</label>
                <input type="checkbox" id="gift_wrap" name="gift_wrap" value="yes"><br>
                <label for="shipping">Shipping Method:</label>
                <select id="shipping" name="shipping">
                    <option value="regular">Regular ($6)</option>
                    <option value="express">Express ($15)</option>
                    <option value="priority">Priority ($25)</option>
                </select><br>
                <input type="hidden" name="fileName" value="<?php echo FileUtility::$currentFile; ?>">
                <input type="submit" name="submit" value="Add Order">
                <input type="reset" value="Reset">
            </form>
            <?php
            // Display errors here
            if (isset($errors)) {
                echo '<div class="errors">';
                foreach ($errors as $error) {
                    echo '<p>' . $error . '</p>';
                }
                echo '</div>';
            }
            ?>
        </section>
        <?php
    }
    static function getOrders($orders){
        ?>
        <section id="order-list">
            <h2>Existing Orders</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order Type</th>
                        <th>Customer ID</th>
                        <th>Amount</th>
                        <th>Gift Wrap</th>
                        <th>Shipping</th>
                        <th>Total Cost</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Display orders here
                    if (isset($orders)) {
                        foreach ($orders as $order) {
                            echo '<tr>';
                            echo '<td>' . $order->type . '</td>';
                            echo '<td>' . $order->custID . '</td>';
                            echo '<td>' . $order->amount . '</td>';
                            echo '<td>' . ($order->giftWrap ? 'Yes' : 'No') . '</td>';
                            echo '<td>' . $order->shipping . '</td>';
                            echo '<td>$' . number_format($order->calculateTotal(), 2) . '</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </section>
        <?php
    }

    static function getFooter($developer){
        ?>
                </main>
            <footer>
                <p>&copy; 2025 Order Management System by <?php echo "$developer" ?> </p>
            </footer>
        </body>
        </html>
        <?php
    }
}