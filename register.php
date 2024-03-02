<?php
require_once('config.php');
require_once('functions.php');
require_once('alert.php');
$msgError = '';
if (isset($_POST['insert_user'])) {
  $firstname = $_POST['firstname'];
  $middlename = $_POST['middlename'];
  $lastname = $_POST['lastname'];
  $gender = $_POST['gender'];
  $contact = $_POST['contact'];
  $address = $_POST['address'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hachage du mot de passe
  $cpassword = $_POST['cpassword'];
  if (!password_verify($cpassword, $password)) {
    $msgError = 'Passwords do not match.';
  } else {
    $sql = "INSERT INTO users (firstname, middlename, lastname, gender, contact, address, email, password, created_at) 
      VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, 'ssssssss', $firstname, $middlename, $lastname, $gender, $contact, $address, $email, $password);
    if (mysqli_stmt_execute($stmt)) {
      $msg = 'Registration successful.';
      header("Location: login.php?msg=" . urlencode($msg));
    }
  }

}
?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('inc/header.php') ?>

<body class="hold-transition">
  <style>
    html,
    body {
      height: calc(100%) !important;
      width: calc(100%) !important;
    }

    body {
      background-image: url("admin<?= $setting_cover; ?>");
      background-size: cover;
      background-repeat: no-repeat;
    }

    .login-title {
      text-shadow: 2px 2px black
    }

    #logo-img {
      height: 150px;
      width: 150px;
      object-fit: scale-down;
      object-position: center center;
      border-radius: 100%;
    }

    @media (max-width:700px) {
      #login {
        flex-direction: column !important
      }
    }

    #login .col-7,
    #login .col-5 {
      width: 100% !important;
      max-width: unset !important
    }
  </style>

  <div class="h-100 d-flex align-items-center w-100" id="login">
    <div class="col-7 h-100 d-flex align-items-center justify-content-center">
    <?php if (!empty($msgError)): ?>
       <?php generateAlert($msgError,'error'); ?>
    <?php endif; ?>

    </div>
    <div class="col-5 h-100  bg-gradient-light">
      <div class="d-flex w-100 h-100 justify-content-center align-items-center">
        <div class="card col-lg-12 card-outline card-maroon rounded-0 shadow">
          <div class="card-header rounded-0">
            <h4 class="text-purle text-center"><b>Registration</b></h4>
          </div>
          <div class="card-body rounded-0">
            <form id="register-frm" action="" method="post">
              <input type="hidden" name="id">
              <div class="row">
                <div class="form-group col-md-6">
                  <input type="text" name="firstname" id="firstname" autofocus
                    class="form-control form-control-sm form-control-border" required>
                  <small class="ml-3 text-maroon">First Name</small>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" name="middlename" id="middlename"
                    class="form-control form-control-sm form-control-border" placeholder="optional">
                  <small class="ml-3 text-maroon">Middle Name</small>
                </div>
                <div class="form-group col-md-6">
                  <input type="text" name="lastname" id="lastname"
                    class="form-control form-control-sm form-control-border" required>
                  <small class="ml-3 text-maroon">Last Name</small>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                  <select name="gender" id="gender" class="form-control form-control-sm form-control-border" required>
                    <option>Male</option>
                    <option>Female</option>
                  </select>
                  <small class="ml-3 text-maroon">Gender</small>
                </div>
                <div class="col-md-6">
                  <input type="number" name="contact" id="contact"
                    class="form-control form-control-sm form-control-border" required>
                  <small class="ml-3 text-maroon">Contact #</small>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <small class="ml-3 text-maroon">Address</small>
                  <textarea name="address" id="address" rows="3" class="form-control form-control-sm rounded-0"
                    required></textarea>
                </div>
              </div>
              <div class="clear-fix my-3"></div>
              <div class="row">
                <div class="form-group col-md-6">
                  <input type="email" name="email" id="email" class="form-control form-control-sm form-control-border"
                    required>
                  <small class="ml-3 text-maroon">Email</small>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-md-6">
                  <div class="input-group input-group-sm">
                    <input type="password" name="password" id="password"
                      class="form-control form-control-sm form-control-border" required>
                    <div class="input-group-append"><span
                        class="input-group-text bg-transparent border-left-0 border-right-0 border-top-0 rounded-0 fa fa-eye-slash pass_view text-muted"></span>
                    </div>
                  </div>
                  <small class="ml-3 text-maroon">Password</small>
                </div>
                <div class="form-group col-md-6">
                  <div class="input-group input-group-sm">
                    <input type="password" name="cpassword" id="cpassword"
                      class="form-control form-control-sm form-control-border" required>
                    <div class="input-group-append"><span
                        class="input-group-text bg-transparent border-left-0 border-right-0 border-top-0 rounded-0 fa fa-eye-slash pass_view text-muted"></span>
                    </div>
                  </div>
                  <small class="ml-3 text-maroon">Confirm Password</small>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <a href="<?php echo base_url . 'login.php' ?>" class="text-maroon">Already have an Account</a>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" name="insert_user"
                    class="btn btn-default bg-gradient-maroon border-0 btn-block btn-flat">Create Account</button>
                </div>
                <!-- /.col -->
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


</body>

</html>