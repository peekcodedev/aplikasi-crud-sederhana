<?php
// edit.php
session_start();
include 'includes/functions.php';
include 'includes/auth.php';
include 'includes/config.php';

// Cek apakah pengguna sudah login dan memiliki role admin
if (!is_logged_in() || $_SESSION['role'] != 'admin') { // Ubah dari $_SESSION['user_role'] menjadi $_SESSION['role']
    redirect('index.php');
}

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
    $profile_picture = $_FILES['profile_picture'];

    // Validasi input
    if (empty($name) || empty($email)) {
        $error = 'Semua field harus diisi!';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email tidak valid!';
    } else {
        // Jika ada file yang diupload
        if ($profile_picture['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $max_size = 2 * 1024 * 1024; // 2MB

            if (!in_array($profile_picture['type'], $allowed_types)) {
                $error = 'File harus berupa gambar (JPEG, PNG, GIF)!';
            } elseif ($profile_picture['size'] > $max_size) {
                $error = 'Ukuran file tidak boleh lebih dari 2MB!';
            } else {
                $upload_dir = 'uploads/';
                $file_name = uniqid() . '_' . basename($profile_picture['name']);
                $file_path = $upload_dir . $file_name;

                if (move_uploaded_file($profile_picture['tmp_name'], $file_path)) {
                    // Update data pengguna dengan foto profil baru
                    $stmt = $conn->prepare("UPDATE users SET name = :name, email = :email, profile_picture = :profile_picture WHERE id = :id");
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':profile_picture', $file_path);
                    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    if ($stmt->execute()) {
                        $_SESSION['notification'] = ['message' => 'Pengguna berhasil diupdate!', 'type' => 'success'];
                        redirect('index.php');
                    } else {
                        $error = 'Gagal mengupdate pengguna!';
                    }
                } else {
                    $error = 'Gagal mengupload file!';
                }
            }
        } else {
            // Update data pengguna tanpa mengubah foto profil
            $stmt = $conn->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
                $_SESSION['notification'] = ['message' => 'Pengguna berhasil diupdate!', 'type' => 'success'];
                redirect('index.php');
            } else {
                $error = 'Gagal mengupdate pengguna!';
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
    <title>Edit Pengguna</title>
    <!-- Menambahkan Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-body">
                        <h3 class="card-title text-center mb-4">Edit Pengguna</h3>
                        
                        <!-- Menampilkan error jika ada -->
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <!-- Form untuk mengedit pengguna -->
                        <form method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                            
                            <div class="form-group">
                                <label for="name">Nama:</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>

                            <div class="form-group">
                                <label for="profile_picture">Foto Profil:</label>
                                <input type="file" class="form-control-file" id="profile_picture" name="profile_picture">
                                <?php if ($user['profile_picture']): ?>
                                    <p>Foto Profil Saat Ini: <img src="<?php echo $user['profile_picture']; ?>" width="100"></p>
                                <?php endif; ?>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block">Update</button>
                        </form>

                        <p class="text-center mt-3"><a href="index.php">Kembali ke Daftar Pengguna</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Menambahkan Bootstrap JS (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
