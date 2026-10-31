<?php
// ==================== DATABASE =======================

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
?>