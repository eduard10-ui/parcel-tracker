<?php

// ==================== DATABASE CONNECTION ====================
include '../db.php';

// ==================== START SESSION ====================
session_start();

// ==================== CHECK FORM SUBMISSION ====================
if (isset($_POST['admin_login'])) {

    // ==================== GET PASSWORD INPUT ====================
    $password = mysqli_real_escape_string($conn, $_POST['admin_password']);

    // ==================== FETCH ADMIN PASSWORD ====================
    $admin_result = mysqli_query(
        $conn,
        "SELECT password FROM admin WHERE id = 0"
    );

    $admin_row = mysqli_fetch_assoc($admin_result);

    // ==================== VERIFY PASSWORD ====================
    if ($password == $admin_row['password']) {

        // ==================== SET ADMIN SESSION ====================
        $_SESSION['admin'] = true;

        // ==================== REDIRECT TO ADMIN DASHBOARD ====================
        header("Location: ../ADMIN/dashboard.php");
        exit();

    } else {

        // ==================== WRONG PASSWORD ====================
        echo "<script>
                alert('Wrong admin password!');
                window.location.href='rider.php';
              </script>";
        exit();

    }

} else {

    // ==================== INVALID ACCESS ====================
    header("Location: rider.php");
    exit();

}

?>