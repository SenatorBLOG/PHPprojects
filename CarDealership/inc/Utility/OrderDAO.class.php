<?php
class OrderDAO {
    private static $db;

    static function initialize() {
        self::$db = new PDOService('Order');
    }

    static function getAll() {
        $query = "SELECT * FROM orders";
        self::$db->query($query);
        self::$db->execute();
        return self::$db->resultSet();
    }

    static function getAllWithDetails() {
        $query = "SELECT o.id, o.order_date, o.status, 
                         c.id AS customer_id, c.name AS customer_name, 
                         ca.id AS car_id, ca.model AS car_model
                  FROM orders o
                  JOIN customers c ON o.customer_id = c.id
                  JOIN cars ca ON o.car_id = ca.id";
        self::$db->query($query);
        self::$db->execute();
        return self::$db->resultSet();
    }

    static function getById(int $id) {
        $query = "SELECT o.id, o.order_date, o.status, 
                         o.customer_id, c.name AS customer_name, 
                         o.car_id, ca.model AS car_model
                  FROM orders o
                  JOIN customers c ON o.customer_id = c.id
                  JOIN cars ca ON o.car_id = ca.id
                  WHERE o.id = :id";
        self::$db->query($query);
        self::$db->bind(':id', $id);
        self::$db->execute();
        return self::$db->singleResult();
    }

    static function create(Order $order) {
        $query = "INSERT INTO orders (customer_id, car_id, order_date, status) 
                  VALUES (:customer_id, :car_id, :order_date, :status)";
        self::$db->query($query);
        self::$db->bind(':customer_id', $order->customer_id, PDO::PARAM_INT);
        self::$db->bind(':car_id', $order->car_id, PDO::PARAM_INT);
        self::$db->bind(':order_date', $order->order_date);
        self::$db->bind(':status', $order->status);
        self::$db->execute();
        return self::$db->rowCount();
    }

    static function update(Order $order) {
        $query = "UPDATE orders SET 
                  customer_id = :customer_id, 
                  car_id = :car_id, 
                  order_date = :order_date, 
                  status = :status 
                  WHERE id = :id";
        self::$db->query($query);
        self::$db->bind(':id', $order->id, PDO::PARAM_INT);
        self::$db->bind(':customer_id', $order->customer_id, PDO::PARAM_INT);
        self::$db->bind(':car_id', $order->car_id, PDO::PARAM_INT);
        self::$db->bind(':order_date', $order->order_date);
        self::$db->bind(':status', $order->status);
        self::$db->execute();
        return self::$db->rowCount();
    }

    static function delete(int $id) {
        $query = "DELETE FROM orders WHERE id = :id";
        self::$db->query($query);
        self::$db->bind(':id', $id, PDO::PARAM_INT);
        self::$db->execute();
        return self::$db->rowCount();
    }
}
?>