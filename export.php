<?php
// export.php
session_start();
include 'includes/functions.php';
include 'includes/auth.php';

if (!is_logged_in()) {
    redirect('login.php');
}

include 'includes/config.php';

// Query untuk mengambil data dari database
try {
    $stmt = $conn->query("SELECT name, email, password, role FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error saat mengambil data: " . $e->getMessage());
}

// Set header untuk file CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="users_export.csv"');

// Buat file CSV
$output = fopen('php://output', 'w');

// Header CSV
fputcsv($output, ['Nama', 'Email', 'Password', 'Role']);

// Data CSV
foreach ($users as $user) {
    fputcsv($output, [
        $user['name'], 
        $user['email'], 
        $user['password'], // Terenkripsi (hashed password)
        $user['role']
    ]);
}

fclose($output);
exit();
?>
