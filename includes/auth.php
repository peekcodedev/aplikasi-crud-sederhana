<?php
// includes/auth.php
include 'config.php';

// Fungsi untuk registrasi
function register($name, $email, $password, $role, $profile_picture = null) {
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash password
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role, profile_picture) VALUES (:name, :email, :password, :role, :profile_picture)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':profile_picture', $profile_picture);
    return $stmt->execute();
}

// Fungsi untuk login
function login($email, $password) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['role'] = $user['role']; // Simpan role di session
        return true;
    }
    return false;
}
?>