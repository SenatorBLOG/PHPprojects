<?php
class Page {
    public static $developerName = "Mikhail Senatorov";
    public static $companyName = "Luxury Cars Inc.";

    static function header() { ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="author" content="<?php echo self::$developerName; ?>">
            <title><?php echo self::$companyName; ?> - Order Management</title>
            <link href="css/styles.css" rel="stylesheet">
        </head>
        <body>
            <header>
                <h1><?php echo self::$companyName; ?> - Order Management</h1>
            </header>
            <main>
    <?php }

    static function footer() { ?>
            </main>
            <footer>
                <p>© <?php echo date("Y"); ?> <?php echo self::$companyName; ?>. All rights reserved.</p>
                <p>Developed by <?php echo self::$developerName; ?></p>
            </footer>
        </body>
        </html>
    <?php }

    static function listOrders(array $orders) { ?>
        <section class="main">
            <h2>Current Orders</h2>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Car</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($orders as $order) {
                        $class = ($i % 2 == 0) ? 'evenRow' : 'oddRow';
                        echo "<tr class=\"$class\">
                                <td>{$order->id}</td>
                                <td>{$order->customer_name}</td>
                                <td>{$order->car_model}</td>
                                <td>{$order->order_date}</td>
                                <td>{$order->status}</td>
                                <td><a href=\"?action=edit&id={$order->id}\">Edit</a></td>
                                <td><a href=\"?action=delete&id={$order->id}\">Delete</a></td>
                              </tr>";
                        $i++;
                    }
                    ?>
                </tbody>
            </table>
        </section>
    <?php }

    static function createOrderForm(array $cars) { ?>
        <section class="form1">
            <h3>Add New Order</h3>
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                <table>
                    <tr>
                        <td>Customer Name</td>
                        <td><input type="text" name="customer_name" placeholder="Enter customer name" required></td>
                    </tr>
                    <tr>
                        <td>Car</td>
                        <td>
                            <select name="car_id" required>
                                <?php
                                foreach ($cars as $car) {
                                    echo "<option value=\"{$car->id}\">{$car->model} ({$car->year})</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Order Date</td>
                        <td><input type="date" name="order_date" required></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td>
                            <select name="status" required>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <input type="hidden" name="action" value="create">
                <input type="submit" value="Add Order">
            </form>
        </section>
    <?php }

    static function editOrderForm($orderToEdit, array $cars) { ?>
    <section class="form1">
        <h3>Edit Order - <?php echo $orderToEdit->id; ?></h3>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <table>
                <tr>
                    <td>Order ID</td>
                    <td><?php echo $orderToEdit->id; ?></td>
                </tr>
                <tr>
                    <td>Customer Name</td>
                    <td><input type="text" name="customer_name" value="<?php echo htmlspecialchars($orderToEdit->customer_name); ?>" required></td>
                </tr>
                <tr>
                    <td>Car</td>
                    <td>
                        <select name="car_id" required>
                            <?php
                            foreach ($cars as $car) {
                                $selected = ($car->id == $orderToEdit->car_id) ? 'selected' : '';
                                echo "<option value=\"{$car->id}\" $selected>{$car->model} ({$car->year})</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Order Date</td>
                    <td><input type="date" name="order_date" value="<?php echo $orderToEdit->order_date; ?>" required></td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <select name="status" required>
                            <option value="pending" <?php echo $orderToEdit->status == 'pending' ? 'selected' : ''; ?>>Pending</option>
                            <option value="completed" <?php echo $orderToEdit->status == 'completed' ? 'selected' : ''; ?>>Completed</option>
                            <option value="cancelled" <?php echo $orderToEdit->status == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                        </select>
                    </td>
                </tr>
            </table>
            <input type="hidden" name="order_id" value="<?php echo $orderToEdit->id; ?>">
            <input type="hidden" name="action" value="edit">
            <input type="submit" value="Update Order">
        </form>
    </section>
    <?php }
}
?>