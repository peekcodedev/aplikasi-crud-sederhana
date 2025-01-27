<?php
// includes/functions.php
function display_error($error) {
    return "<div style='color: red;'>$error</div>";
}

function is_logged_in() {
    return isset($_SESSION['user_id']);
}

function redirect($url) {
    header("Location: $url");
    exit();
}

// Fungsi untuk pagination
function get_pagination($total_records, $records_per_page, $current_page) {
    $total_pages = ceil($total_records / $records_per_page);
    return [
        'total_pages' => $total_pages,
        'offset' => ($current_page - 1) * $records_per_page
    ];
}

// Fungsi untuk sorting
function get_sort_order($column) {
    $order = 'asc';
    if (isset($_GET['order']) && $_GET['order'] == 'asc') {
        $order = 'desc';
    }
    return "ORDER BY $column $order";
}
?>