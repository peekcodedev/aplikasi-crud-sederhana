<?php
// config.php
$host = 'localhost'; // Host database
$dbname = 'crud_example'; // Nama database
$username = 'root'; // Username database
$password = ''; // Password database

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>