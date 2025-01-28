<?php
// delete.php
session_start();
include 'includes/functions.php';
include 'includes/auth.php';
include 'includes/config.php';

// Cek apakah pengguna sudah login dan memiliki role admin
if (!is_logged_in() || $_SESSION['user_role'] != 'admin') {
    redirect('index.php');
}

// Proses penghapusan data
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Ambil data pengguna untuk menghapus foto profil jika ada
    $stmt = $conn->prepare("SELECT profile_picture FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Hapus foto profil jika ada
        if ($user['profile_picture'] && file_exists($user['profile_picture'])) {
            unlink($user['profile_picture']);
        }

        // Hapus data pengguna dari database
        $stmt = $conn->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            redirect('index.php');
        } else {
            die("Gagal menghapus pengguna!");
        }
    } else {
        die("Pengguna tidak ditemukan!");
    }
} else {
    die("ID tidak valid!");
}
?>