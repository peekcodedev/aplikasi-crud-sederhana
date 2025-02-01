<?php
// dashboard.php
session_start();
include 'includes/functions.php';
include 'includes/auth.php';

if (!is_logged_in()) {
    redirect('login.php');
}

include 'includes/config.php';

// Query untuk mengambil data dari database
try {
    $stmt = $conn->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error saat mengambil data: " . $e->getMessage());
}

// Tampilkan notifikasi jika ada
if (isset($_SESSION['notification'])): ?>
    <div class="notification <?php echo $_SESSION['notification']['type']; ?>">
        <?php echo $_SESSION['notification']['message']; ?>
    </div>
    <?php unset($_SESSION['notification']); ?>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container mt-4">
        <h1>Selamat datang, <?php echo $_SESSION['user_name']; ?>!</h1>
        <p>Ini adalah halaman dashboard.</p>

        <!-- Tombol Tambah Pengguna, Export, dan Import -->
        <?php if (is_admin()): ?>
            <div class="mb-3">
                <a href="create.php" class="btn btn-primary">Tambah Pengguna</a>
                <a href="export.php" class="btn btn-success">Export Data</a>
                <a href="import.php" class="btn btn-danger">Import Data</a>
            </div>
        <?php endif; ?>

        <!-- Tabel Data Pengguna -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Foto Profil</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['id']); ?></td>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['role']); ?></td>
                                <td>
                                    <?php if ($user['profile_picture']): ?>
                                        <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Foto Profil" width="50">
                                    <?php else: ?>
                                        Tidak ada foto
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (is_admin() || $user['id'] == $_SESSION['user_id']): ?>
                                        <a href="edit.php?id=<?php echo $user['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <?php endif; ?>
                                    <?php if (is_admin()): ?>
                                        <a href="delete.php?id=<?php echo $user['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data pengguna.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Tombol Logout -->
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
