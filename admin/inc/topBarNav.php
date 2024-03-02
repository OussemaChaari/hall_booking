<style>
  .user-img {
    position: absolute;
    height: 27px;
    width: 27px;
    object-fit: cover;
    left: -7%;
    top: -12%;
  }

  .btn-rounded {
    border-radius: 50px;
  }
</style>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-light text-sm shadow-sm">
  <!-- Left navbar links -->
  <ul class="navbar-nav d-flex flex-row align-items-center">
    <li class="nav-item">
      <a id="toggleSidebar" class="nav-link" data-widget="pushmenu" href="#" role="button"><i
          class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="">Hall Booking System</a>
    </li>
  </ul>
  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">

    <li class="nav-item d-flex">
      <a class="dropdown-item" href="<?php echo base_url ?>admin/edit_profile.php"><span class="fa fa-user">
          <?= $_SESSION['first_name']; ?>
          <?= $_SESSION['last_name']; ?>
        </span></a>
      <a class="dropdown-item" href="<?php echo base_url ?>admin/logout.php"><span class="fas fa-sign-out-alt"> </span>
        Logout</a>
    </li>


  </ul>
</nav>
<!-- /.navbar -->
<script src="<?php echo base_url ?>dist/js/global.js"></script>