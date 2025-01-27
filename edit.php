<?php
// edit.php
session_start();
include 'includes/functions.php';
include 'includes/auth.php';

if (!is_logged_in()) {
    redirect('login.php');
}

include 'includes/config.php';

$error = '';
$user = [];

// Ambil data pengguna berdasarkan ID
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $error = 'Pengguna tidak ditemukan!';
    }
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    // Validasi input
    if (empty($name) || empty($email)) {
        $error = 'Semua field harus diisi!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email tidak valid!';
    } else {
        // Update data pengguna
        $stmt = $conn->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute()) {
            redirect('index.php');
        } else {
            $error = 'Gagal mengupdate pengguna!';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pengguna</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Edit Pengguna</h1>
    <?php if ($error): ?>
        <?php echo display_error($error); ?>
    <?php endif; ?>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        <div class="form-group">
            <label for="name">Nama:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        <button type="submit">Update</button>
    </form>
    <br>
    <a href="index.php">Kembali ke Daftar Pengguna</a>
</body>
</html>