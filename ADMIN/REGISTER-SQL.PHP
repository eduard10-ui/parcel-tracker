<?php
// ==================== DATABASE CONNECTION ====================
include "../DB.PHP";

// ==================== CHECK IF BUTTON IS CLICKED ====================
if (isset($_POST['register_btn'])) {

    // ==================== REQUIRED FIELDS ====================
    $required_fields = [
        'rider_name',
        'rider_contact',
        'receiver_name',
        'receiver_contact',
        'address',
        'price',
        'weight',
        'length',
        'width',
        'location'
    ];

    // ==================== VALIDATE EMPTY FIELDS ====================
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            echo "<script>
                    alert('Please fill in all fields!');
                    window.location.href='REGISTER-PARCEL.PHP';
                  </script>";
            exit();
        }
    }

    // ==================== GENERATE TRACKING CODE ====================
    $tracking_code = "FT-" . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));

    // ==================== GET FORM DATA ====================
    $rider_name       = mysqli_real_escape_string($conn, $_POST['rider_name']);
    $rider_contact    = mysqli_real_escape_string($conn, $_POST['rider_contact']);
    $receiver_name    = mysqli_real_escape_string($conn, $_POST['receiver_name']);
    $receiver_contact = mysqli_real_escape_string($conn, $_POST['receiver_contact']);
    $address          = mysqli_real_escape_string($conn, $_POST['address']);

    // ==================== VALIDATE NUMERIC INPUT ====================
    if (
        !is_numeric($_POST['price']) ||
        !is_numeric($_POST['weight']) ||
        !is_numeric($_POST['length']) ||
        !is_numeric($_POST['width'])
    ) {
        echo "<script>
                alert('Price, weight, length, and width must be numbers!');
                window.location.href='REGISTER-PARCEL.PHP';
              </script>";
        exit();
    }

    // ==================== CONVERT TO NUMBER ====================
    $user_price = $_POST['price'] + 0;
    $weight     = $_POST['weight'] + 0;
    $length     = $_POST['length'] + 0;
    $width      = $_POST['width'] + 0;

    // ==================== PRICE COMPUTATION ====================
    $fixed_shipping = 20;
    $weight_fee     = $weight * 5;
    $area_fee       = ($length * $width) / 5000;

    $total_price = $user_price + $fixed_shipping + $weight_fee + $area_fee;

    // ==================== OTHER DATA ====================
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $status   = mysqli_real_escape_string($conn, $_POST['status']);

    // ==================== INSERT QUERY ====================
    $sql = "INSERT INTO parcel (
                tracking_code,
                rider_name,
                rider_contact,
                receiver_name,
                receiver_contact,
                address,
                price,
                weight,
                length,
                width,
                location,
                status
            )
            VALUES (
                '$tracking_code',
                '$rider_name',
                '$rider_contact',
                '$receiver_name',
                '$receiver_contact',
                '$address',
                '$total_price',
                '$weight',
                '$length',
                '$width',
                '$location',
                '$status'
            )";

    // ==================== EXECUTE QUERY ====================
    if (mysqli_query($conn, $sql)) {

        // ==================== SUCCESS MESSAGE ====================
        echo "<script>
                alert('Parcel registered successfully! Tracking Code: $tracking_code');
                window.location.href='REGISTER-PARCEL.PHP';
              </script>";
        exit();

    } else {

        // ==================== ERROR MESSAGE ====================
        echo "<script>
                alert('Registration failed! Please try again.');
                window.location.href='REGISTER-PARCEL.PHP';
              </script>";
        exit();
    }
}
?>