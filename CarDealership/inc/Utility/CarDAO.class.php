<?php
class CarDAO {
    private static $db;

    static function initialize() {
        self::$db = new PDOService('Car');
    }

    static function getAll() {
        $query = "SELECT * FROM cars";
        self::$db->query($query);
        self::$db->execute();
        return self::$db->resultSet();
    }

    static function getById(int $id) {
        $query = "SELECT * FROM cars WHERE id = :id";
        self::$db->query($query);
        self::$db->bind(':id', $id);
        self::$db->execute();
        return self::$db->singleResult();
    }
}
?>