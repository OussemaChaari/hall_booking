<?php 
require_once('../config.php');
require_once('../functions.php');
require_once('../alert.php');

session_start(); 
if (isset($_POST['login_admin'])) {
  $email = $_POST["email"];
  $password = $_POST["password"];
  $stmt = $con->prepare("SELECT * FROM tbl_admin WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();
  if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      // Verify the password
      if ($password = $row['password']) {
        $_SESSION['admin_id'] = $row['id'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['first_name'] = $row['first_name'];
        $_SESSION['last_name'] = $row['last_name'];
        $msg = 'Login Admin successful!';
        header("Location: dashboard.php?msg=" . urlencode($msg));
        exit();
        
      } else {
          echo "Incorrect password.";
      }
  } else {
      echo "User not found.";
  }
}
?>
<!DOCTYPE html>
<html lang="en" class="" style="height: auto;">
<?php require_once('../inc/header.php') ?>

<body class="hold-transition ">
  <style>
    html,
    body {
      height: calc(100%) !important;
      width: calc(100%) !important;
    }

    body {
      background-image: url("<?= $cheminTransforme; ?>");
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
    <?php
            if (isset($_GET['msg'])) {
                $msg = urldecode($_GET['msg']);
                generateAlert($msg);
            }
            ?>
      <div class="w-100">
        <h1 class="text-center py-3 login-title"><b>Welcome To <?= $setting_info['name']; ?></b></h1>
      </div>

    </div>
    <div class="col-5 h-100 bg-gradient">
      <div class="d-flex w-100 h-100 justify-content-center align-items-center">
        <div class="card col-sm-12 col-md-6 col-lg-3 card-outline card-maroon rounded-0 shadow">
          <div class="card-header rounded-0">
            <h4 class="text-purle text-center"><b>Login</b></h4>
          </div>
          <div class="card-body rounded-0">
            <form action="" method="post">
              <div class="input-group mb-3">
                <input type="email" class="form-control" autofocus name="email" placeholder="Email">
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
                  <a href="<?php echo base_url ?>" class="text-maroon">Go to Website</a>
                </div>
                <div class="col-4">
                  <button type="submit" class="btn btn-default bg-gradient-maroon border-0 btn-block btn-flat" name="login_admin">Sign
                    In</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
 
</body>
</html>