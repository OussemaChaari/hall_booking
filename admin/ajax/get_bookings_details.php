<?php
require_once('../../config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $bookingId = mysqli_real_escape_string($con, $_POST['id']);
    $query = "SELECT bookings.*, users.middlename, halls.name,
    GROUP_CONCAT(services.name) as service_names
    FROM bookings
    INNER JOIN users ON bookings.client_id = users.id
    INNER JOIN halls ON bookings.hall_id = halls.id
    LEFT JOIN services ON FIND_IN_SET(services.id, REPLACE(bookings.services_ids, '|', ','))
    WHERE bookings.id = ?
    GROUP BY bookings.id";

    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $bookingId);

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $bookingDetails = mysqli_fetch_assoc($result);
            ?>
            <div id="outprint" class="list-group">
                <div class="row">
                    <div class="col-4 bg-gradient-maroon border">Client Name:</div>
                    <div class="col-8 text-dark border">
                        <?php echo $bookingDetails['middlename']; ?>
                    </div>
                    <div class="col-4 bg-gradient-maroon border">Hall Name</div>
                    <div class="col-8 text-dark border">
                        <?php echo $bookingDetails['name']; ?>
                    </div>
                    <div class="col-4 bg-gradient-maroon border">Total Guests</div>
                    <div class="col-8 text-dark border">
                        <?php echo $bookingDetails['total_guests']; ?>
                    </div>
                    <div class="col-4 bg-gradient-maroon border">Wedding Schedule</div>
                    <div class="col-8 text-dark border">
                        <?php echo $bookingDetails['wedding_schedule']; ?>
                    </div>
                    <div class="col-4 bg-gradient-maroon border">Remarks</div>
                    <div class="col-8 text-dark border">
                        <?php echo $bookingDetails['remarks']; ?>
                    </div>
                    <div class="col-4 bg-gradient-maroon border">Created at</div>
                    <div class="col-8 text-dark border">
                        <?php echo $bookingDetails['created_at']; ?>
                    </div>
                    <div class="col-4 bg-gradient-maroon border">Status</div>
                    <div class="col-8 text-dark border">
                        <?php echo ($bookingDetails['pending'] == 1 ? 'Approved' : 'Pending'); ?>
                    </div>
                    <div class="col-4 bg-gradient-maroon border">Services</div>
                    <div class="col-8 text-dark border">
                        <?php echo $bookingDetails['service_names']; ?>
                    </div>
                </div>
            </div>
            <?php
        } else {
            echo 'Error: Failed to retrieve booking details';
        }
    } else {
        echo 'Error: Failed to execute prepared statement';
    }

    mysqli_stmt_close($stmt);
}
?>