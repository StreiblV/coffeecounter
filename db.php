<?php
require_once 'credentials.php';

try {

    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $password, [

        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

    ]);

} catch (PDOException $e) {

    die("Database connection failed: " . $e->getMessage());

}
