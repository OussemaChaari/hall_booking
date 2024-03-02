<nav class="w-100 px-2 py-1 position-fixed top-0 bg-gradient-maroon text-light" id="login-nav"
    style="position: fixed !important;
    top: 0 !important;
    z-index: 1037;
    padding: 0.3em 2.5em !important;    background: #d81b60 linear-gradient(180deg, #de3d78, #d81b60) repeat-x !important;">
    <div class="d-flex justify-content-between w-100">
        <div>
            <span class="mr-2"><i class="fa fa-phone mr-1"></i>
                <?= $setting_info['contact_number']; ?>
            </span>
        </div>
        <div>
            <?php if (isset($_SESSION['user_id'])) { ?>
                <div class="dropdown" style="display:inline!important;">
                    <button class="btn btn-secondary dropdown-toggle" style="padding:0px!important;background:transparent!important;
    border: none!important;" type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <?php echo $_SESSION['user_email']; ?>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="./profile.php">Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="./logout.php">Logout</a>
                    </div>
                </div>
            <?php } else { ?>
                <a href="./register.php" class="mx-2 text-light">Register</a>
                <a href="./login.php" class="mx-2 text-light">Client Login</a>
            <?php } ?>
            <a href="./admin" class="mx-2 text-light">Admin Login</a>
        </div>
    </div>
</nav>
<nav class="navbar navbar-expand-lg navbar-light border-0 text-sm" id='top-Nav'
    style="top:30px;background: #0000000d !important;">
    <div class="container">
        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="./" class="">
                        <img src="./admin<?= $logo; ?>" alt="" style="width: 65px;height: 45px;">
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./" class="nav-link <?= isset($page) && $page == 'home' ? "active" : "" ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a href="./?page=halls"
                        class="nav-link <?= isset($page) && $page == 'halls' ? "active" : "" ?>">Halls</a>
                </li>
                <li class="nav-item">
                    <a href="./?page=services"
                        class="nav-link <?= isset($page) && $page == 'services' ? "active" : "" ?>">Services</a>
                </li>
                <li class="nav-item">
                    <a href="./?page=about"
                        class="nav-link <?= isset($page) && $page == 'about' ? "active" : "" ?>">About Us</a>
                </li>
                <li class="nav-item">
                    <a href="./?page=contact_us"
                        class="nav-link <?= isset($page) && $page == 'contact_us' ? "active" : "" ?>">Contact
                        Us</a>
                </li>
            
            </ul>


        </div>
        <!-- Right navbar links -->
        <div class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        </div>
    </div>
</nav>