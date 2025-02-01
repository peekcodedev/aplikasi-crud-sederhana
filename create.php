<?php
// create.php
session_start();
include 'includes/functions.php';
include 'includes/auth.php';

if (!is_logged_in()) {
    redirect('login.php');
}

include 'includes/config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']); // Tambahkan input password

    // Validasi input
    if (empty($name) || empty($email) || empty($password)) {
        $error = 'Semua field harus diisi!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email tidak valid!';
    } else {
        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Tambahkan data ke database
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password); // Sertakan password
        if ($stmt->execute()) {
            $_SESSION['notification'] = ['message' => 'Pengguna berhasil ditambahkan!', 'type' => 'success'];
            redirect('index.php');
        } else {
            $error = 'Gagal menambahkan pengguna!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengguna</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Tambah Pengguna</h1>
    <?php if ($error): ?>
        <?php echo display_error($error); ?>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <label for="name">Nama:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Simpan</button>
    </form>
    <br>
    <a href="index.php">Kembali ke Daftar Pengguna</a>
</body>
</html>