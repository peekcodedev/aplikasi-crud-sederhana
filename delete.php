<?php
include 'config.php';

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();

header("Location: index.php");
exit();
?>