<?php
/**
 * Database connection function
 * @return PDO Database connection
 */
function connectDB() {
    $host = "localhost";
    $dbname = "ventas_comerciales";
    $username = "dwes";
    $password = "dwes";

    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (PDOException $e) {
        die("Error connecting to the database: " . $e->getMessage());
    }
}


