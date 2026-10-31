<?php

// ==================== DATABASE CONNECTION ====================
include '../DB.PHP';

// ==================== CHECK REQUEST METHOD ====================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // ==================== CHECK REQUIRED DATA ====================
    if (!isset($_POST['parcel_id']) || !isset($_POST['track_code'])) {
        echo "<script> alert('Invalid parcel data!'); window.location.href='RIDER.PHP';</script>";
        exit();
    }
    // ==================== GET FORM DATA ====================
    $id           = mysqli_real_escape_string($conn, $_POST['parcel_id']);
    $track_code   = mysqli_real_escape_string($conn, $_POST['track_code']);
    $new_status   = mysqli_real_escape_string($conn, $_POST['new_status']);
    $new_location = mysqli_real_escape_string($conn, $_POST['new_location']);

    // ==================== CHECK EMPTY LOCATION ====================
    if (empty($new_location)) {
        echo "<script> alert('Location cannot be empty! Please update location first.'); window.location.href='RIDER.PHP'; </script>";
        exit();
    }

    // ==================== UPDATE PARCEL TABLE ====================
    $update_main = "
        UPDATE parcel
        SET
            status = '$new_status',
            location = '$new_location'
        WHERE id = '$id'
    ";

    $main_success = mysqli_query($conn, $update_main);

    // ==================== CHECK UPDATE RESULT ====================
    if (!$main_success) {

        echo "<script>
                alert('Failed to update parcel! Please try again.');
                window.location.href='RIDER.PHP';
              </script>";
        exit();

    }

    // ==================== INSERT HISTORY RECORD ====================
    $insert_history = "
        INSERT INTO parcel_history (
            tracking_code,
            status,
            location
        )
        VALUES (
            '$track_code',
            '$new_status',
            '$new_location'
        )
    ";

    $history_success = mysqli_query($conn, $insert_history);

    // ==================== CHECK HISTORY RESULT ====================
    if (!$history_success) {

        echo "<script>
                alert('Parcel updated but history not saved!');
                window.location.href='RIDER.PHP';
              </script>";
        exit();

    }

    // ==================== REDIRECT SUCCESS ====================
    header("Location: RIDER.PHP?msg=success");
    exit();

} else {

    // ==================== INVALID ACCESS ====================
    header("Location: RIDER.PHP");
    exit();

}

?>