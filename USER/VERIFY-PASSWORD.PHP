<?php
// ==================== DATABASE CONNECTION ====================
include '../DB.PHP';
// ==================== SESSION START ====================
session_start();
// ==================== LOGIN HANDLER ====================
if (isset($_POST['login'])) {
    // ==================== INPUT SANITIZATION ====================
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    // ==================== CHECK ADMIN ACCOUNT (id = 0) ====================
    $admin_result = mysqli_query($conn, "SELECT password FROM admin WHERE id=0");
    $admin_row = mysqli_fetch_assoc($admin_result);
    // ==================== CHECK RIDER ACCOUNT (id = 1) ====================
    $rider_result = mysqli_query($conn,"SELECT password FROM admin WHERE id=1");
    $rider_row = mysqli_fetch_assoc($rider_result);
    // ==================== ADMIN LOGIN VALIDATION ====================
    if ($password == $admin_row['password']) {
        $_SESSION['admin'] = true;
        header("Location: ../admin/dashboard.php");
        exit();
    }
    // ==================== RIDER LOGIN VALIDATION ====================
    elseif ($password == $rider_row['password']) {
        $_SESSION['rider'] = true;
        header("Location: ../rider/rider.php");
        exit();
    }
    // ==================== INVALID LOGIN ====================
    else {
        echo "<script>alert('wrong password');window.location.href='user.php';</script>";
        exit();
    }
}
?>