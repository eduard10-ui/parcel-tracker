<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['is_admin']) && !isset($_SESSION['admin'])) {
    header("Location: ../USER/login.php");
    exit();
}

// ==================== DATABASE CONNECTION ====================
include "../db.php";

// ==================== GET ID FROM URL ====================
$id = $_GET['id'];

// ==================== DELETE QUERY ====================
$sql = "DELETE FROM parcel WHERE id = $id";

// ==================== EXECUTE DELETE ====================
if (mysqli_query($conn, $sql)) {

    // ==================== SUCCESS MESSAGE ====================
    echo "<script>
            alert('Parcel deleted successfully!');
            window.location.href='dashboard.php';
          </script>";

} else {

    // ==================== ERROR MESSAGE ====================
    echo "<script>
            alert('Delete failed! Please try again.');
            window.location.href='dashboard.php';
          </script>";

}


include ".//db.php";


?>