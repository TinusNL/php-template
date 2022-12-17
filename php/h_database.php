<?php

class h_database
{
    public static $conn;

    public static function prepare($query)
    {
        $stmt = self::$conn->stmt_init();
        $stmt->prepare($query);

        return $stmt;
    }
}

h_database::$conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);
if (h_database::$conn->connect_error) {
    die("Connection failed: " . h_database::$conn->connect_error);
}
