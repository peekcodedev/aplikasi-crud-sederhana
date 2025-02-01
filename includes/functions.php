<?php
// includes/functions.php
function display_error($error) {
    return "<div style='color: red;'>$error</div>";
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function redirect($url) {
    header("Location: $url");
    exit();
}

// Fungsi untuk validasi file upload
function validate_file($file) {
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 2 * 1024 * 1024; // 2MB

    if (!in_array($file['type'], $allowed_types)) {
        return "File harus berupa gambar (JPEG, PNG, GIF).";
    }

    if ($file['size'] > $max_size) {
        return "Ukuran file tidak boleh lebih dari 2MB.";
    }

    return null; // Tidak ada error
}

// Fungsi untuk pengecekan role
function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}
?>