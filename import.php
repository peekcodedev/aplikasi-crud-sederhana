<?php
// import.php
session_start();
include 'includes/functions.php';
include 'includes/auth.php';

if (!is_logged_in()) {
    redirect('login.php');
}

include 'includes/config.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $file = $_FILES['csv_file']['tmp_name'];

        // Baca file CSV
        if (($handle = fopen($file, 'r')) !== FALSE) {
            // Lewati header
            fgetcsv($handle);

            // Proses setiap baris
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                $name = $data[0]; // Nama
                $email = $data[1]; // Email
                $role = $data[2]; // Role
                $password = isset($data[3]) ? $data[3] : 'defaultpassword';  // Default password jika tidak ada

                // Validasi data
                if (!empty($name) && !empty($email) && !empty($role)) {
                    $valid_roles = ['admin', 'user'];
                    if (!in_array($role, $valid_roles)) {
                        $error = "Role '$role' tidak valid. Hanya 'admin' dan 'user' yang diizinkan.";
                        break;
                    }

                    // Pastikan email tidak duplikat
                    $stmt_check_email = $conn->prepare("SELECT * FROM users WHERE email = :email");
                    $stmt_check_email->bindParam(':email', $email);
                    $stmt_check_email->execute();
                    if ($stmt_check_email->rowCount() > 0) {
                        $error = "Email '$email' sudah terdaftar.";
                        break;
                    }

                    // Hash password sebelum disimpan
                    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                    // Insert data ke database
                    try {
                        $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)");
                        $stmt->bindParam(':name', $name);
                        $stmt->bindParam(':email', $email);
                        $stmt->bindParam(':password', $hashed_password);
                        $stmt->bindParam(':role', $role);
                        $stmt->execute();
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                }
            }

            fclose($handle);
            $_SESSION['notification'] = ['message' => 'Data berhasil diimport!', 'type' => 'success'];
            redirect('dashboard.php');
        } else {
            $error = 'Gagal membaca file CSV!';
        }
    } else {
        $error = 'File CSV tidak valid!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Data</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Import Data</h1>
    <?php if ($error): ?>
        <div class="notification error"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <label for="csv_file">Pilih File CSV:</label>
        <input type="file" id="csv_file" name="csv_file" required>
        <br>
        <button type="submit">Import</button>
    </form>
    <br>
    <a href="dashboard.php">Kembali ke Dashboard</a>
</body>
</html>
