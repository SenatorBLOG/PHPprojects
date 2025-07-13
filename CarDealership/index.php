<?php
require_once 'inc/config.inc.php';
require_once 'inc/Utility/PDOService.class.php';
require_once 'inc/Entity/Manufacturer.class.php';
require_once 'inc/Entity/Car.class.php';
require_once 'inc/Entity/Customer.class.php';
require_once 'inc/Entity/Order.class.php';
require_once 'inc/Utility/ManufacturerDAO.class.php';
require_once 'inc/Utility/CarDAO.class.php';
require_once 'inc/Utility/CustomerDAO.class.php';
require_once 'inc/Utility/OrderDAO.class.php';
require_once 'inc/Entity/Page.class.php';

// Initializing the DAO
ManufacturerDAO::initialize();
CarDAO::initialize();
CustomerDAO::initialize();
OrderDAO::initialize();

// Processing POST requests
if (!empty($_POST)) {
    if ($_POST["action"] == "create") {
        try {
            // Get or create a client
            $customerName = trim($_POST["customer_name"]);
            if (empty($customerName)) {
                throw new Exception("The client's name cannot be empty.");
            }
            $customerId = CustomerDAO::getOrCreateCustomer($customerName);

            $newOrder = new Order();
            $newOrder->customer_id = $customerId;
            $newOrder->car_id = (int)$_POST["car_id"];
            $newOrder->order_date = $_POST["order_date"];
            $newOrder->status = $_POST["status"];
            if (OrderDAO::create($newOrder)) {
                header("Location: " . $_SERVER["PHP_SELF"]);
                exit;
            } else {
                echo "<p class='error'>Error: The order could not be created. Check the data.</p>";
            }
        } catch (Exception $e) {
            echo "<p class='error'>Error: " . htmlspecialchars($e->GetMessage()) . "</p>";
        }
    } else if ($_POST["action"] == "edit") {
        try {
            // Get or create a client
            $customerName = trim($_POST["customer_name"]);
            if (empty($customerName)) {
                throw new Exception("The client's name cannot be empty.");
            }
            $customerId = CustomerDAO::getOrCreateCustomer($customerName);

            $orderToUpdate = new Order();
            $orderToUpdate->id = (int)$_POST["order_id"];
            $orderToUpdate->customer_id = $customerId;
            $orderToUpdate->car_id = (int)$_POST["car_id"];
            $orderToUpdate->order_date = $_POST["order_date"];
            $orderToUpdate->status = $_POST["status"];
            if (OrderDAO::update($orderToUpdate)) {
                header("Location: " . $_SERVER["PHP_SELF"]);
                exit;
            } else {
                echo "<p class='error'>Error: The order could not be updated.</p>";
            }
        } catch (Exception $e) {
            echo "<p class='error'>Error: " . htmlspecialchars($e->GetMessage()) . "</p>";
        }
    }
}

// Processing a delete GET request
if (isset($_GET["action"]) && $_GET["action"] == "delete" && !empty($_GET["id"])) {
    try {
        if (OrderDAO::delete((int)$_GET["id"])) {
            header("Location: " . $_SERVER["PHP_SELF"]);
            exit;
        } else {
            echo "<p class='error'>Error: The order could not be deleted.</p>";
        }
    } catch (Exception $e) {
        echo "<p class='error'>Error: " . htmlspecialchars($e->GetMessage()) . "</p>";
}
}

// Page rendering
Page::header();
Page::listOrders(OrderDAO::getAllWithDetails());
if (isset($_GET["action"]) && $_GET["action"] == "edit" && !empty($_GET["id"])) {
    $orderToEdit = OrderDAO::getById((int)$_GET["id"]);
    Page::editOrderForm($orderToEdit, CarDAO::getAll());
} else {
    Page::createOrderForm(CarDAO::getAll());
}
Page::footer();
?>