<?php
// delete.php
session_start();
include 'includes/functions.php';
include 'includes/auth.php';
include 'includes/config.php';

// Cek apakah pengguna sudah login dan memiliki role admin
if (!is_logged_in() || !is_admin()) {
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
            $_SESSION['notification'] = ['message' => 'Pengguna berhasil dihapus!', 'type' => 'success'];
        } else {
            $_SESSION['notification'] = ['message' => 'Gagal menghapus pengguna!', 'type' => 'error'];
        }
    } else {
        $_SESSION['notification'] = ['message' => 'Pengguna tidak ditemukan!', 'type' => 'error'];
    }
} else {
    $_SESSION['notification'] = ['message' => 'ID tidak valid!', 'type' => 'error'];
}

// Redirect ke halaman index.php
redirect('index.php');
?>