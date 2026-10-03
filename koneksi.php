<?php
$host     = "localhost";
$username = "root";
$password = "Raissasql15";
$dbname   = "sisega";

try {
    $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       
        PDO::ATTR_EMULATE_PREPARES   => false,                  
    ];
    $koneksi = new PDO($dsn, $username, $password, $options);

} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>