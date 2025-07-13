<?php
class ManufacturerDAO {
    private static $db;

    static function initialize() {
        self::$db = new PDOService('Manufacturer');
    }

    static function getAll() {
        $query = "SELECT * FROM manufacturers";
        self::$db->query($query);
        self::$db->execute();
        return self::$db->resultSet();
    }

    static function getById(int $id) {
        $query = "SELECT * FROM manufacturers WHERE id = :id";
        self::$db->query($query);
        self::$db->bind(':id', $id);
        self::$db->execute();
        return self::$db->singleResult();
    }
}
?>