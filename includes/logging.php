// includes/logging.php
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

function getLogger() {
    $log = new Logger('app_log');
    // Log akan disimpan di file logs/app.log
    $log->pushHandler(new StreamHandler(__DIR__ . '/../logs/app.log', Logger::DEBUG));
    return $log;
}

// Fungsi untuk menyimpan log ke database
function logToDatabase($level, $message, $context = null) {
    global $conn; // Menggunakan koneksi yang ada
    $stmt = $conn->prepare("INSERT INTO logs (level, message, context) VALUES (:level, :message, :context)");
    $stmt->bindParam(':level', $level);
    $stmt->bindParam(':message', $message);
    $stmt->bindParam(':context', json_encode($context));
    $stmt->execute();
}