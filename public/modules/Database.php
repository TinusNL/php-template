<?php

class Database
{
    public static PDO $conn;

    // Prepare a query
    public static function prepare($query): PDOStatement
    {
        $stmt = self::$conn->prepare($query);
        return $stmt;
    }
}

try {
    // Create a new PDO instance
    $dsn = "mysql:host=" . DATABASE_HOST . ";dbname=" . DATABASE_NAME;
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
    );

    Database::$conn = new PDO($dsn, DATABASE_USER, DATABASE_PASS, $options);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
