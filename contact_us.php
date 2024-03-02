<?php
require_once('config.php');
require_once('alert.php');
if (isset($_POST['send'])) {
    $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
    $contact = mysqli_real_escape_string($con, $_POST['contact']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $message = mysqli_real_escape_string($con, $_POST['message']);
    $insertQuery = "INSERT INTO messages (fullname, contact, email, message) VALUES ('$fullname', '$contact', '$email', '$message')";
    if (mysqli_query($con, $insertQuery)) {
       echo globalAlert("Your message has been sent successfully");
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>
<style>
    .layout-navbar-fixed .wrapper .content-wrapper {
        margin-top: calc(1.8rem + 1px) !important;
    }
</style>

<div class="col-12">
    <div class="row my-5 ">
        <div class="col-md-5">
            <div class="card card-outline card-maroon rounded-0 shadow">
                <div class="card-header">
                    <h4 class="card-title">Contact Information</h4>
                </div>
                <div class="card-body rounded-0">
                    <dl>
                        <dt class="text-muted"><i class="fa fa-envelope"></i> Email</dt>
                        <dd class="pl-4">
                            <?= $setting_info['email']; ?>
                        </dd>
                        <dt class="text-muted"><i class="fa fa-phone"></i> Contact #</dt>
                        <dd class="pl-4">
                            <?= $setting_info['contact_number']; ?>
                        </dd>
                        <dt class="text-muted"><i class="fa fa-map-marked-alt"></i> Location</dt>
                        <dd class="pl-4">
                            <?= $setting_info['office_address']; ?>
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card rounded-0 card-outline card-maroon shadow">
                <div class="card-body rounded-0">
                    <h2 class="text-center">Message Us</h2>
                    <center>
                        <hr class="bg-maroon border-maroon w-25 border-2">
                    </center>
                    <form action="" id="message-form" method="post">
                        <input type="hidden" name="id">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control form-control-sm form-control-border"
                                    id="fullname" name="fullname" required placeholder="John Smith">
                                <small class="px-3 text-muted">Full Name</small>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control form-control-sm form-control-border" id="contact"
                                    name="contact" required placeholder="xxxxxxxxxxxxx">
                                <small class="px-3 text-muted">Contact #</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="email" class="form-control form-control-sm form-control-border" id="email"
                                    name="email" required placeholder="xxxxxx@xxxxxx.xxx">
                                <small class="px-3 text-muted">Email</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <small class="text-muted">Message</small>
                                <textarea name="message" id="message" rows="4"
                                    class="form-control form-control-sm rounded-0" required
                                    placeholder="Write your message here"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 text-center">
                                <button type="submit" name="send"
                                    class="btn btn-default bg-gradient-maroon rounded-pill col-5">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>