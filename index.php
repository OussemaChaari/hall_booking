<?php require_once('config.php');
require_once('functions.php');
require_once('alert.php');
session_start();
if ($setting_info['shutdown'] == '0') {
    echo '<div class="alert alert-warning fixed-top" style="top:85px;">
        This site is currently not available. Please check back later.
    </div>';
}
if (isset($_POST['save_booking'])) {
    $client_id = mysqli_real_escape_string($con, $_POST['client_id']);
    $hall_id = mysqli_real_escape_string($con, $_POST['hall_id']);
    $wedding_schedule = mysqli_real_escape_string($con, $_POST['wedding_schedule']);
    $total_guests = mysqli_real_escape_string($con, $_POST['total_guests']);
    $remarks = mysqli_real_escape_string($con, $_POST['remarks']);
    $services_ids = isset($_POST['services_ids']) ? '|' . implode('|,|', $_POST['services_ids']) . '|' : '';
    $insertQuery = "INSERT INTO bookings (client_id, hall_id, services_ids, wedding_schedule, total_guests, remarks) 
                    VALUES ('$client_id', '$hall_id', '$services_ids', '$wedding_schedule', '$total_guests', '$remarks')";

    if (mysqli_query($con, $insertQuery)) {
        $msg = "Booking saved successfully!";
        header("Location:?msg=" . urlencode($msg));
    }else{
        $msg = "Failed To save Booking!";
        header("Location:?msg=" . urlencode($msg));
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<style>
    #header {
        height: 70vh;
        width: calc(100%);
        position: relative;
        top: -5em;
    }

    #header:before {
        content: "";
        position: absolute;
        height: calc(100%);
        width: calc(100%);
        background-image: url('admin<?= $setting_cover; ?>');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center center;
        filter: brightness(0.85);
    }

    #header>div {
        position: absolute;
        height: calc(100%);
        width: calc(100%);
        z-index: 2;
    }

    #top-Nav a.nav-link.active {
        color: #d81b60;
        font-weight: 900;
        position: relative;
    }

    #top-Nav a.nav-link.active:before {
        content: "";
        position: absolute;
        border-bottom: 2px solid #d81b60;
        width: 33.33%;
        left: 33.33%;
        bottom: 0;
    }
</style>
<?php require_once('inc/header.php') ?>

<body class="layout-top-nav layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        <?php
        if (isset($_GET['msg'])) {
            $msg = urldecode($_GET['msg']);
            generateAlert($msg);
        }
        ?>
        <?php $page = isset($_GET['page']) ? $_GET['page'] : 'home'; ?>
        <?php require_once('inc/topbar.php') ?>
        <div class="content-wrapper pt-5">
            <?php if ($page == "home" || $page == "about"): ?>
                <div id="header" class="shadow mb-4">
                    <div class="d-flex justify-content-center h-100 w-100 align-items-center flex-column px-3">
                        <h1 class="w-100 text-center site-title px-5">
                            <?= $setting_info['name']; ?>

                        </h1>
                        <button type="button" data-toggle="modal" data-target="#BookModal"
                            class="btn btn-lg btn-default bg-gradient-maroon border-0 rounded-pill px-4 w-25" id="book_now"
                            <?php echo isset($_SESSION['user_id']) ? '' : 'disabled'; ?>     <?php echo isset($_SESSION['user_id']) ? '' : 'title="Login required to book"'; ?>>
                            Book Now!
                        </button>


                    </div>
                </div>
            <?php endif; ?>
            <?php
            if (!file_exists($page . ".php") && !is_dir($page)) {
                include '404.html';
            } else {
                if (is_dir($page))
                    include $page . '/index.php';
                else
                    include $page . '.php';

            }
            ?>
        </div>
    </div>
    <div class="modal fade" id="BookModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Booking Now</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="book-form" method="post">
                    <div class="modal-body">
                        <input type="hidden" name="client_id" value="<?= $_SESSION['user_id']; ?>">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="hall_id" class="control-label">Hall</label>
                                <select name="hall_id" id="hall_id"
                                    class="form-control form-control-sm form-control-border selectHall" required>
                                    <option value="" disabled selected>Select Hall</option>
                                    <?php
                                    $halls = $con->query("SELECT * FROM `halls` where status = 1");
                                    while ($row = $halls->fetch_assoc()):
                                        ?>
                                        <option value="<?= $row['id'] ?>">
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
                                    class="form-control form-control-sm form-control-border selectService" multiple
                                    required>
                                    <?php
                                    $service = $con->query("SELECT * FROM `services` where status = 1");
                                    while ($row = $service->fetch_assoc()):
                                        ?>
                                        <option value="<?= $row['id'] ?>">
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
                                    class="form-control form-control-sm form-control-border" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="total_guests" class="control-label">Total Guests</label>
                                <input type="number" id="total_guests" name="total_guests"
                                    class="form-control form-control-sm form-control-border text-right" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="remarks" class="control-label">Remarks</label>
                                <textarea name="remarks" id="remarks" class="form-control form-control-sm rounded-0"
                                    rows="3" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="save_booking" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php require_once('inc/footer.php') ?>
    <script>
        $(function () {
            $('#BookModal').on('shown.bs.modal', function () {
                $('.selectService').select2({
                    placeholder: "Please select Service",
                    width: "100%",
                    dropdownParent: $('#BookModal')
                });
                $('.selectHall').select2({
                    placeholder: "Please select Hall",
                    width: "100%",
                    dropdownParent: $('#BookModal')
                });
            });
        })
    </script>
</body>

</html>