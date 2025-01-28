<?php
// includes/auth.php
session_start();
include 'config.php';

// Fungsi untuk registrasi
function register($name, $email, $password, $profile_picture) {
    global $conn;
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash password
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, profile_picture, role) VALUES (:name, :email, :password, :profile_picture, 'user')");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);
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
        $_SESSION['user_role'] = $user['role']; // Set session role
        return true;
    }
    return false;
}
?>