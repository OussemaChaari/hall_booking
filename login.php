<?php
require_once('config.php');
require_once('functions.php');
require_once('alert.php');
$msgError = '';
if (isset($_POST['login_user'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  $sql = "SELECT * FROM users WHERE email = ?";
  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, 's', $email);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  if ($result && $user = mysqli_fetch_assoc($result)) {
    if (password_verify($password, $user['password'])) {
      session_start();
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_email'] = $user['email'];
      $msg = 'Login successful!';
      header("Location:index.php?msg=" . urlencode($msg));
      exit();
    } else {
      $msgError = 'Invalid email or password.';
    }
  } else {
    $msgError = 'Invalid email or password.';
  }
  mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en" style="height: auto;">
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

    #login {
      flex-direction: column !important
    }

    #logo-img {
      height: 150px;
      width: 150px;
      object-fit: scale-down;
      object-position: center center;
      border-radius: 100%;
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
        <?php generateAlert($msgError, 'error'); ?>
      <?php endif; ?>
      <?php
      if (isset($_GET['msg'])) {
        $msg = urldecode($_GET['msg']);
        generateAlert($msg);
      }
      ?>
    </div>
    <div class="col-5 h-100 bg-gradient">
      <div class="d-flex w-100 h-100 justify-content-center align-items-center">
        <div class="card col-sm-12 col-md-6 col-lg-3 card-outline card-maroon rounded-0 shadow">
          <div class="card-header rounded-0">
            <h4 class="text-purle text-center"><b>Login</b></h4>
          </div>
          <div class="card-body rounded-0">
            <form id="client-login-frm" action="" method="post">
              <div class="input-group mb-3">
                <input type="text" class="form-control" autofocus name="email" placeholder="Email">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-user"></span>
                  </div>
                </div>
              </div>
              <div class="input-group mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-8">
                  <a href="<?php echo base_url . 'register.php' ?>" class="text-maroon">Create an Account</a>
                </div>
                <!-- /.col -->
                <div class="col-4">
                  <button type="submit" name="login_user"
                    class="btn btn-default border-0 bg-gradient-maroon btn-block btn-flat">Sign
                    In</button>
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