<?php
require_once('config.php');
require_once('functions.php');
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$userID = $_SESSION['user_id'];

$query = "SELECT * FROM `users` WHERE `id` = ?";
$statement = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($statement, 'i', $userID);
mysqli_stmt_execute($statement);
$result = mysqli_stmt_get_result($statement);
if ($row = mysqli_fetch_assoc($result)) {
    $firstName = $row['firstname'];
    $middleName = $row['middlename'];
    $lastName = $row['lastname'];
    $gender = $row['gender'];
    $contact = $row['contact'];
    $address = $row['address'];
    $email = $row['email'];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch user input from the form
    $firstName = $_POST['firstname'];
    $middleName = $_POST['middlename'];
    $lastName = $_POST['lastname'];
    $gender = $_POST['gender'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $enteredEmail = $_POST['email']; // Entered email from the form
    $newPassword = $_POST['password'];
    // Update the user profile
    if (!empty($newPassword)) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateQuery = "UPDATE `users` SET `firstname`=?, `middlename`=?, `lastname`=?, `gender`=?, `contact`=?, `address`=?, `email`=?, `password`=? WHERE `id`=?";
        $updateStatement = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($updateStatement, 'ssssssssi', $firstName, $middleName, $lastName, $gender, $contact, $address, $email, $hashedPassword, $userID);
    } else {
        $updateQuery = "UPDATE `users` SET `firstname`=?, `middlename`=?, `lastname`=?, `gender`=?, `contact`=?, `address`=?, `email`=? WHERE `id`=?";
        $updateStatement = mysqli_prepare($con, $updateQuery);
        mysqli_stmt_bind_param($updateStatement, 'sssssssi', $firstName, $middleName, $lastName, $gender, $contact, $address, $email, $userID);
    }

    if (mysqli_stmt_execute($updateStatement)) {
        $msg = 'Profile updated successfully!';
        header("Location: login.php?msg=" . urlencode($msg));
    }
}
?>
<style>
    #cimg {
        width: 100%;
        height: 25vh;
        object-fit: scale-down;
        object-position: center center;
    }
</style>
<?php require_once('inc/header.php') ?>

<body class="layout-top-nav layout-fixed layout-navbar-fixed">
    <div class="wrapper">
        <?php require_once('inc/topbar.php') ?>

        <div class="content py-5">
            <div class="container">
                <div class="card card-outline card-maroon rounded-0 shadow">
                    <div class="card-header">
                        <h4 class="card-title">My Profile</h4>

                    </div>
                    <div class="card-body">
                        <div class="container-fluid">
                            <form id="client-form" action="" method="post">
                                <input type="hidden" name="user_id" value="<?= $_SESSION['user_id']; ?>">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <input type="text" name="firstname" id="firstname" value="<?= $firstName; ?>"
                                            autofocus class="form-control form-control-sm form-control-border" required
                                            value="">
                                        <small class="ml-3 text-maroon">First Name</small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="text" name="middlename" id="middlename" value="<?= $middleName; ?>"
                                            class="form-control form-control-sm form-control-border"
                                            placeholder="optional" value="">
                                        <small class="ml-3 text-maroon">Middle Name</small>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input type="text" name="lastname" id="lastname" value="<?= $lastName; ?>"
                                            class="form-control form-control-sm form-control-border" required value="">
                                        <small class="ml-3 text-maroon">Last Name</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <select name="gender" id="gender"
                                            class="form-control form-control-sm form-control-border">
                                            <option <?= ($gender == 'Male') ? 'selected' : ''; ?>>Male</option>
                                            <option <?= ($gender == 'Female') ? 'selected' : ''; ?>>Female</option>
                                        </select>
                                        <small class="ml-3 text-maroon">Gender</small>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" name="contact" id="contact"
                                            class="form-control form-control-sm form-control-border"
                                            value="<?= $contact; ?>" required>
                                        <small class="ml-3 text-maroon">Contact #</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <small class="ml-3 text-maroon">Address</small>
                                        <textarea name="address" id="address" rows="3"
                                            class="form-control form-control-sm rounded-0"
                                            required><?= $address; ?></textarea>
                                    </div>
                                </div>
                                <div class="clear-fix my-3"></div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <input type="email" name="email" id="email"
                                            class="form-control form-control-sm form-control-border" required
                                            value="<?= $email; ?>">
                                        <small class="ml-3 text-maroon">Email</small>
                                    </div>


                                    <div class="form-group col-md-6">
                                        <div class="input-group input-group-sm">
                                            <input type="password" name="password" id="password"
                                                class="form-control form-control-sm form-control-border">
                                            <div class="input-group-append"><span
                                                    class="input-group-text bg-transparent border-left-0 border-right-0 border-top-0 rounded-0 fa fa-eye-slash pass_view text-muted"></span>
                                            </div>
                                        </div>
                                        <small class="ml-3 text-maroon">New Password</small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-8">
                                    </div>
                                    <div class="col-4">
                                        <button type="submit"
                                            class="btn btn-default bg-gradient-maroon border-0 btn-block btn-flat">Update
                                            Account</button>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require_once('inc/footer.php') ?>

</body>

</html>