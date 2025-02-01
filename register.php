<?php
// register.php
session_start();
include 'includes/config.php';
include 'includes/auth.php'; // Pastikan ini di-include
include 'includes/functions.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = 'user'; // Default role adalah 'user'

    // Validasi input
    if (empty($name) || empty($email) || empty($password)) {
        $error = 'Semua field harus diisi!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email tidak valid!';
    } else {
        // Handle file upload (jika ada fitur upload foto profil)
        $profile_picture = null;
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
            $file_error = validate_file($_FILES['profile_picture']); // Panggil fungsi validate_file()
            if ($file_error) {
                $error = $file_error;
            } else {
                $upload_dir = 'uploads/';
                $file_name = uniqid() . '_' . basename($_FILES['profile_picture']['name']);
                $file_path = $upload_dir . $file_name;
                if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $file_path)) {
                    $profile_picture = $file_path;
                } else {
                    $error = 'Gagal mengupload file!';
                }
            }
        }

        if (empty($error)) {
            if (register($name, $email, $password, $role, $profile_picture)) {
                $_SESSION['notification'] = ['message' => 'Registrasi berhasil! Silakan login.', 'type' => 'success'];
                redirect('login.php');
            } else {
                $error = 'Registrasi gagal!';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Register</h1>
    <?php if ($error): ?>
        <?php echo display_error($error); ?>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <label for="name">Nama:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <label for="profile_picture">Foto Profil:</label>
        <input type="file" id="profile_picture" name="profile_picture">
        <br>
        <button type="submit">Register</button>
    </form>
    <p>Sudah punya akun? <a href="login.php">Login di sini</a>.</p>
</body>
</html>