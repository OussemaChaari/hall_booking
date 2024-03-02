<?php
require_once('../config.php');
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: " . base_url . "admin/index.php");
    exit();
}
if (isset($_SESSION['admin_id'])) {
    $adminId = $_SESSION['admin_id'];
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_admin'])) {
        $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
        $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);
        $query = "UPDATE tbl_admin SET first_name = ?, last_name = ?, email = ?, password = ? WHERE id = ?";
        $statement = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($statement, 'ssssi', $firstname, $lastname, $email, $password, $adminId);
        if (mysqli_stmt_execute($statement)) {
            $msg = 'Admin details updated successfully.';
        header("Location:index.php?msg=" . urlencode($msg));
        } 
    }

    $query = "SELECT * FROM tbl_admin WHERE id = ?";
    $statement = mysqli_prepare($con, $query);

    mysqli_stmt_bind_param($statement, 'i', $adminId);

    mysqli_stmt_execute($statement);

    $result = mysqli_stmt_get_result($statement);

    if ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $firstname = $row['first_name'];
        $lastname = $row['last_name'];
        $email = $row['email'];
        $password = $row['password'];

    } 
}
?>

<!DOCTYPE html>
<html lang="en">
<?php require_once('../inc/header.php') ?>

<body class="sidebar-mini layout-fixed control-sidebar-slide-open layout-navbar-fixed sidebar-mini-md sidebar-mini-xs"
    data-new-gr-c-s-check-loaded="14.991.0" data-gr-ext-installed="" style="height: auto;">
    <div class="wrapper">
        <div class="content-wrapper" style="height:100vh;margin-top:3rem;">

            <?php require_once('inc/topBarNav.php') ?>
            <?php require_once('inc/navigation.php') ?>
            
            <div class="col-lg-12" style="padding:25px;">
                <div class="card card-outline card-maroon mx-4">
                <form action="" id="manage-user" method="post">

                    <div class="card-body">
                        <div class="container-fluid">
                                <div class="form-group">
                                    <label for="name">First Name</label>
                                    <input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo $firstname; ?>"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="name">Last Name</label>
                                    <input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo $lastname; ?>"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="username">Email</label>
                                    <input type="emil" name="email" id="email" class="form-control" value="<?= $email; ?>"
                                        required autocomplete="off">
                                </div>
                                <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control" value="<?= $password; ?>" autocomplete="off">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="togglePassword">
                                            <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-md-12">
                            <div class="row">
                                <button type="submit" class="btn btn-sm btn-primary" name="update_admin">Update</button>
                            </div>
                        </div>
                    </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
    <script src="<?php echo base_url ?>dist/js/global.js"></script>
    <script>
    $(document).ready(function () {
        // Toggle password visibility
        $('#togglePassword').on('click', function () {
            const passwordInput = $('#password');
            const icon = $(this).find('i');
            const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';

            passwordInput.attr('type', type);
            // Change icon based on the password visibility
            icon.toggleClass('fa-eye-slash fa-eye');
        });
    });
</script>

</body>

</html>