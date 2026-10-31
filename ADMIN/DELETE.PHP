<?php

// ==================== DATABASE CONNECTION ====================
include "../DB.PHP";

// ==================== GET ID FROM URL ====================
$id = $_GET['id'];

// ==================== DELETE QUERY ====================
$sql = "DELETE FROM parcel WHERE id = $id";

// ==================== EXECUTE DELETE ====================
if (mysqli_query($conn, $sql)) {

    // ==================== SUCCESS MESSAGE ====================
    echo "<script>
            alert('Parcel deleted successfully!');
            window.location.href='DASHBOARD.PHP';
          </script>";

} else {

    // ==================== ERROR MESSAGE ====================
    echo "<script>
            alert('Delete failed! Please try again.');
            window.location.href='DASHBOARD.PHP';
          </script>";

}


include ".//db.php";


?>