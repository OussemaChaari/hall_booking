<?php
require_once('../../config.php');

if (isset($_POST['update_booking']) && isset($_POST['bookingId'])) {
    $bookingId = mysqli_real_escape_string($con, $_POST['bookingId']);
    $hall_id = mysqli_real_escape_string($con, $_POST['hall_id']);
    $services_ids = implode('|', array_map(function($value) use ($con) {
        return mysqli_real_escape_string($con, $value);
    }, $_POST['services_ids']));    $wedding_schedule = mysqli_real_escape_string($con, $_POST['wedding_schedule']);
    $total_guests = mysqli_real_escape_string($con, $_POST['total_guests']);
    $remarks = mysqli_real_escape_string($con, $_POST['remarks']);
    $booking_status = mysqli_real_escape_string($con, $_POST['booking_status']);
    $query = "UPDATE bookings SET
              hall_id = '$hall_id',
              services_ids = '$services_ids',
              wedding_schedule = '$wedding_schedule',
              total_guests = '$total_guests',
              remarks = '$remarks',
              pending = '$booking_status'
              WHERE id = '$bookingId'";

    $result = mysqli_query($con, $query);

    if ($result) {
        $msg = "Booking updated successfully!";
        header("Location:bookings.php?msg=" . urlencode($msg));
    }
} else {
    echo 'Error: Invalid request';
}
?>