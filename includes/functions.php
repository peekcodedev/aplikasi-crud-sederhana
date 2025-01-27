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
?>