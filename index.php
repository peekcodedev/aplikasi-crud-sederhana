<?php
// index.php (di root folder)
session_start(); // Pastikan session dimulai di sini

if (isset($_SESSION['notification'])) {
    $notification = $_SESSION['notification'];
    echo "<div style='color: {$notification['type']};'>{$notification['message']}</div>";
    unset($_SESSION['notification']); // Hapus pesan notifikasi setelah ditampilkan
}

// Cek apakah user sudah login
if (isset($_SESSION['user_id'])) {
    // Jika sudah login, arahkan ke dashboard
    header("Location: dashboard.php");
    exit();
} else {
    // Jika belum login, arahkan ke login
    header("Location: login.php");
    exit();
}
?>
