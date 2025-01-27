<?php
// index.php
//session_start();
include 'includes/functions.php';
include 'includes/auth.php';

if (!is_logged_in()) {
    redirect('login.php');
}

include 'includes/config.php';

// Konfigurasi pagination
$records_per_page = 5; // Jumlah data per halaman
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Konfigurasi pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Konfigurasi sorting
$sort_column = isset($_GET['sort']) ? $_GET['sort'] : 'id';
$sort_order = get_sort_order($sort_column);

// Query untuk mengambil data dari database
try {
    // Query dasar
    $sql = "SELECT * FROM users";
    $where = '';

    // Tambahkan pencarian jika ada
    if (!empty($search)) {
        $where = " WHERE name LIKE :search OR email LIKE :search";
    }

    // Hitung total data
    $stmt_total = $conn->prepare("SELECT COUNT(*) FROM users $where");
    if (!empty($search)) {
        $stmt_total->bindValue(':search', "%$search%", PDO::PARAM_STR);
    }
    $stmt_total->execute();
    $total_records = $stmt_total->fetchColumn();

    // Hitung pagination
    $pagination = get_pagination($total_records, $records_per_page, $current_page);

    // Query dengan pagination dan sorting
    $sql .= " $where $sort_order LIMIT :limit OFFSET :offset";
    $stmt = $conn->prepare($sql);

    // Bind parameter pencarian
    if (!empty($search)) {
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    }

    // Bind parameter pagination
    $stmt->bindValue(':limit', $records_per_page, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $pagination['offset'], PDO::PARAM_INT);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error saat mengambil data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Sederhana</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Daftar Pengguna</h1>
    <a href="create.php" style="background-color: #008CBA;" class="btn">Tambah Pengguna</a>
    <br><br>

    <!-- Form Pencarian -->
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Cari nama atau email..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Cari</button>
    </form>
    <br>

    <!-- Tabel Data -->
    <table>
        <tr>
            <th><a href="?sort=id&order=<?php echo isset($_GET['order']) && $_GET['order'] == 'asc' ? 'desc' : 'asc'; ?>">ID</a></th>
            <th><a href="?sort=name&order=<?php echo isset($_GET['order']) && $_GET['order'] == 'asc' ? 'desc' : 'asc'; ?>">Nama</a></th>
            <th><a href="?sort=email&order=<?php echo isset($_GET['order']) && $_GET['order'] == 'asc' ? 'desc' : 'asc'; ?>">Email</a></th>
            <th>Aksi</th>
        </tr>
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $user['id']; ?>" class="btn btn-edit">Edit</a>
                    <a href="delete.php?id=<?php echo $user['id']; ?>" class="btn btn-delete" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Tidak ada data pengguna.</td>
            </tr>
        <?php endif; ?>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        <?php if ($current_page > 1): ?>
            <a href="?page=<?php echo $current_page - 1; ?>&search=<?php echo htmlspecialchars($search); ?>&sort=<?php echo $sort_column; ?>&order=<?php echo isset($_GET['order']) ? $_GET['order'] : 'asc'; ?>">Sebelumnya</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $pagination['total_pages']; $i++): ?>
            <a href="?page=<?php echo $i; ?>&search=<?php echo htmlspecialchars($search); ?>&sort=<?php echo $sort_column; ?>&order=<?php echo isset($_GET['order']) ? $_GET['order'] : 'asc'; ?>" <?php echo $i == $current_page ? 'class="active"' : ''; ?>><?php echo $i; ?></a>
        <?php endfor; ?>

        <?php if ($current_page < $pagination['total_pages']): ?>
            <a href="?page=<?php echo $current_page + 1; ?>&search=<?php echo htmlspecialchars($search); ?>&sort=<?php echo $sort_column; ?>&order=<?php echo isset($_GET['order']) ? $_GET['order'] : 'asc'; ?>">Selanjutnya</a>
        <?php endif; ?>
    </div>
</body>
</html>