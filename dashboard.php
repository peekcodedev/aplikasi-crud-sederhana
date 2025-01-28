<?php
// dashboard.php
//session_start(); // Pastikan session dimulai
include 'includes/functions.php';
include 'includes/auth.php';

if (!is_logged_in()) {
    redirect('login.php');
}

// Periksa apakah session 'user_role' ada
if (!isset($_SESSION['user_role'])) {
    $_SESSION['user_role'] = 'user'; // Set default role jika tidak ada
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Selamat datang, <?php echo $_SESSION['user_name']; ?>!</h1>
    <p>Ini adalah halaman dashboard. Role Anda: <?php echo $_SESSION['user_role']; ?></p>
    <a href="logout.php">Logout</a>
</body>
</html>