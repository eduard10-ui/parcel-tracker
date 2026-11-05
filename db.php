<?php
// ==================== DATABASE (LOCAL XAMPP) =======================

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'tracker';

// connection
$conn = mysqli_connect($host, $user, $pass, $db);

// check connection
if (!$conn) {
    echo "<script>
            alert('Database connection failed!');
          </script>";
    exit();
}

// ==================== BLOCK DIRECT URL ACCESS ====================
// If someone opens /ELECTIVE/db.php directly in the browser, redirect them.
// Internal includes (from other PHP files) will NOT trigger this, because
// SCRIPT_FILENAME points to the parent script, not db.php.
if (basename($_SERVER['SCRIPT_FILENAME']) === 'db.php') {
    header("Location: USER/INTRO.HTML");
    exit();
}
?>