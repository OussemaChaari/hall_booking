<?php require_once('../../config.php');
session_start();
require_once('../../alert.php');
if (!isset($_SESSION['admin_id'])) {
    header("Location: " . base_url . "admin/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php require_once('../../inc/header.php') ?>

<body class="sidebar-mini layout-fixed control-sidebar-slide-open layout-navbar-fixed sidebar-mini-md sidebar-mini-xs"
    data-new-gr-c-s-check-loaded="14.991.0" data-gr-ext-installed="" style="height: auto;">
    <div class="wrapper">
        <div class="content-wrapper" style="height:100vh;margin-top:3rem;background-color:transparent;">
            <?php require_once('../inc/topBarNav.php') ?>
            <?php require_once('../inc/navigation.php') ?>
            <div class="col-lg-12" style="padding:25px;">
                <div class="card card-outline card-maroon rounded-0">
                    <div class="card-header">
                        <h3 class="card-title">List of Clients</h3>
                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="container-fluid">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr class="bg-maroon">
                                            <th>#</th>
                                            <th>firstname</th>
                                            <th>middlename</th>
                                            <th>lastname</th>
                                            <th>contact</th>
                                            <th>address</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $qry = $con->query("SELECT * FROM `users`");
                                        while ($row = $qry->fetch_assoc()):
                                            ?>
                                            <tr>
                                                <td class="text-center">
                                                    <?php echo $i++; ?>
                                                </td>
                                                <td>
                                                    <?php echo ucwords($row['firstname']) ?>
                                                </td>
                                                <td>
                                                    <?php echo ucwords($row['middlename']) ?>
                                                </td>
                                                <td>
                                                    <?php echo ucwords($row['lastname']) ?>
                                                </td>
                                                <td>
                                                    <?php echo ucwords($row['contact']) ?>
                                                </td>
                                                <td>
                                                    <?php echo ucwords($row['address']) ?>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.table').dataTable();
        });
    </script>
    <script src="<?php echo base_url ?>dist/js/global.js"></script>
</body>

</html>