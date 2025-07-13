<?php
class CustomerDAO {
    private static $db;

    static function initialize() {
        self::$db = new PDOService('Customer');
    }

    static function getAll() {
        $query = "SELECT * FROM customers";
        self::$db->query($query);
        self::$db->execute();
        return self::$db->resultSet();
    }

    static function getById(int $id) {
        $query = "SELECT * FROM customers WHERE id = :id";
        self::$db->query($query);
        self::$db->bind(':id', $id);
        self::$db->execute();
        return self::$db->singleResult();
    }

    static function getOrCreateCustomer(string $name) {
        $query = "SELECT id FROM customers WHERE name = :name";
        self::$db->query($query);
        self::$db->bind(':name', $name);
        self::$db->execute();
        $result = self::$db->singleResult();
        if ($result) {
            return $result->id;
        } else {
            $query = "INSERT INTO customers (name) VALUES (:name)";
            self::$db->query($query);
            self::$db->bind(':name', $name);
            self::$db->execute();
            return self::$db->lastInsertedId();
        }
    }
}
?>