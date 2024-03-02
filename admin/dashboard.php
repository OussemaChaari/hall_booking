<?php
require_once('../config.php');
session_start();
require_once('../alert.php');
if (!isset($_SESSION['admin_id'])) {
    header("Location: " . base_url . "admin/index.php");
    exit();
}
?>
<script src="<?php echo base_url ?>dist/js/global.js"></script>

<!DOCTYPE html>
<html lang="en">
<?php require_once('../inc/header.php') ?>

<body class="sidebar-mini layout-fixed control-sidebar-slide-open layout-navbar-fixed sidebar-mini-md sidebar-mini-xs"
    data-new-gr-c-s-check-loaded="14.991.0" data-gr-ext-installed="" style="height: auto;">
    <div class="wrapper">
        <div class="content-wrapper" style="height:100vh;margin-top:3rem;">

            <?php require_once('inc/topBarNav.php') ?>
            <?php require_once('inc/navigation.php') ?>
            <?php
            if (isset($_GET['msg'])) {
                $msg = urldecode($_GET['msg']);
                generateAlert($msg);
            }
            ?>

            <div class="d-flex">
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 mt-2">
                    <div class="info-box bg-gradient-light shadow">
                        <span class="info-box-icon bg-gradient-maroon elevation-1"><i
                                class="fas fa-door-closed"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Active Halls</span>
                            <span class="info-box-number text-right">
                                <?php
                                echo $con->query("SELECT * FROM `halls` WHERE status = 1")->num_rows;
                                ?>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 mt-2">
                    <div class="info-box bg-gradient-light shadow">
                        <span class="info-box-icon bg-gradient-fuchsia elevation-1"><i
                                class="fas fa-th-list"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Active Services</span>
                            <span class="info-box-number text-right">
                                <?php
                                echo $con->query("SELECT * FROM `services` where status = 1")->num_rows;
                                ?>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 mt-2">
                    <div class="info-box bg-gradient-light shadow">
                        <span class="info-box-icon bg-gradient-pink elevation-1"><i
                                class="fas fa-clipboard-list"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Bookings</span>
                            <span class="info-box-number text-right">
                                <?php
                                echo $con->query("SELECT * FROM `bookings` ")->num_rows;
                                ?>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <div class="col-12 col-sm-12 col-md-6 col-lg-3 mt-2">
                    <div class="info-box bg-gradient-light shadow">
                        <span class="info-box-icon bg-gradient-teal elevation-1"><i
                                class="fas fa-question-circle"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Unread Inquiries</span>
                            <span class="info-box-number text-right">
                                <?php
                                echo $con->query("SELECT * FROM `messages` WHERE `read` = 0")->num_rows;
                                ?>
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            </div>

        </div>
    </div>
</body>

</html>