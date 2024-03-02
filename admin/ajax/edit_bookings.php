<?php
require_once('../../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $bookingId = mysqli_real_escape_string($con, $_POST['id']);
    $query = "SELECT * FROM bookings WHERE id = $bookingId";
    $result = mysqli_query($con, $query);
    if ($result) {
        $bookingDetails = mysqli_fetch_assoc($result);
        ?>
        <form action="update_booking.php" id="edit-form" method="post">
            <input type="hidden" name="bookingId" value="<?= $bookingId; ?>">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="hall_id" class="control-label">Hall</label>
                        <select name="hall_id" id="hall_id"
                            class="form-control form-control-sm form-control-border selectHall select2" required>
                            <option value="" disabled>Select Hall</option>
                            <?php
                            $halls = $con->query("SELECT * FROM `halls` where status = 1");
                            while ($row = $halls->fetch_assoc()):
                                $selected = ($row['id'] == $bookingDetails['hall_id']) ? 'selected' : '';
                                ?>
                                <option value="<?= $row['id'] ?>" <?= $selected ?>>
                                    <?= $row['code'] . " - " . $row['name'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="services_ids" class="control-label">Services</label>
                        <select name="services_ids[]" id="services_ids"
                            class="form-control form-control-sm form-control-border select2" multiple="multiple" required>
                            <?php
                            $service = $con->query("SELECT * FROM `services` where status = 1");
                            while ($row = $service->fetch_assoc()):
                                $selected = (in_array($row['id'], explode('|', $bookingDetails['services_ids']))) ? 'selected' : '';
                                ?>
                                <option value="<?= $row['id'] ?>" <?= $selected ?>>
                                    <?= $row['name'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group">
                        <label for="wedding_schedule" class="control-label">Wedding Schedule</label>
                        <input type="date" id="wedding_schedule" name="wedding_schedule"
                            value="<?= $bookingDetails['wedding_schedule']; ?>"
                            class="form-control form-control-sm form-control-border" required>
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="total_guests" class="control-label">Total Guests</label>
                        <input type="number" id="total_guests" name="total_guests"
                            value="<?= $bookingDetails['total_guests']; ?>"
                            class="form-control form-control-sm form-control-border text-right" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="remarks" class="control-label">Remarks</label>
                        <textarea name="remarks" id="remarks" class="form-control form-control-sm rounded-0" rows="3"
                            required><?= $bookingDetails['remarks']; ?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 form-group">
                        <label for="booking_status" class="control-label">Booking Status</label>
                        <select name="booking_status" id="booking_status"
                            class="form-control form-control-sm form-control-border" required>
                            <option value="0" <?= ($bookingDetails['pending'] == 0) ? 'selected' : ''; ?>>Pending</option>
                            <option value="1" <?= ($bookingDetails['pending'] == 1) ? 'selected' : ''; ?>>Approved</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" name="update_booking" class="btn btn-primary">Save changes</button>
            </div>
        </form>
        <?php
    } else {
        echo 'Error: Failed to retrieve booking details';
    }
}

?>
<script>
    $(document).ready(function () {
        $('.select2').select2();
    });
</script>