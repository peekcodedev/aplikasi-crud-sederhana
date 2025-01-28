<?php
// register.php
//session_start();
include 'includes/config.php';
include 'includes/auth.php';
include 'includes/functions.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $profile_picture = $_FILES['profile_picture'];

    // Validasi input
    if (empty($name) || empty($email) || empty($password)) {
        $error = 'Semua field harus diisi!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email tidak valid!';
    } else {
        // Validasi file upload
        if ($profile_picture['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $max_size = 2 * 1024 * 1024; // 2MB

            if (!in_array($profile_picture['type'], $allowed_types)) {
                $error = 'File harus berupa gambar (JPEG, PNG, GIF)!';
            } elseif ($profile_picture['size'] > $max_size) {
                $error = 'Ukuran file tidak boleh lebih dari 2MB!';
            } else {
                $upload_dir = __DIR__ . '/uploads/'; // Gunakan path absolut
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true); // Buat folder jika tidak ada
                }

                $file_name = uniqid() . '_' . basename($profile_picture['name']);
                $file_path = $upload_dir . $file_name;

                if (move_uploaded_file($profile_picture['tmp_name'], $file_path)) {
                    if (register($name, $email, $password, $file_path)) {
                        redirect('login.php');
                    } else {
                        $error = 'Registrasi gagal!';
                    }
                } else {
                    $error = 'Gagal mengupload file!';
                }
            }
        } else {
            if (register($name, $email, $password, null)) {
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