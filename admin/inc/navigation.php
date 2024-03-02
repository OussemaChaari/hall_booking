<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-light elevation-4 sidebar-no-expand bg-gradient-maroon">
    <!-- Brand Logo -->
    <a href="" class="brand-link bg-transparent text-sm shadow-sm bg-gradient-maroon">
        <span class="brand-text font-weight-light">Welcome To My Hall Booking</span>
    </a>
    <!-- Sidebar -->
    <div
        class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
        <div class="os-resize-observer-host observed">
            <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
        </div>
        <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
            <div class="os-resize-observer"></div>
        </div>
        <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 646px;"></div>
        <div class="os-padding">
            <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
                <div class="os-content" style="padding: 5px 8px; height: 100%; width: 100%;">
                    <!-- Sidebar user panel (optional) -->
                    <div class="clearfix"></div>
                    <!-- Sidebar Menu -->
                    <nav class="">
                        <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child text-dark"
                            data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item dropdown">
                                <a href="<?php echo base_url ?>admin/dashboard.php"
                                    class="nav-link text-light nav-home">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url ?>admin/bookings/bookings.php"
                                    class="nav-link text-light nav-bookings">
                                    <i class="nav-icon fas fa-clipboard-list"></i>
                                    <p>
                                        Booking Applications
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url ?>admin/inquiries/inquiries.php"
                                    class="nav-link text-light nav-inquiries">
                                    <i class="nav-icon fas fa-question-circle"></i>
                                    <p>
                                        Inquiries
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url ?>admin/clients/clients.php"
                                    class="nav-link text-light nav-clients">
                                    <i class="nav-icon fas fa-user-friends"></i>
                                    <p>
                                        Client Lists
                                    </p>
                                </a>
                            </li>
                            <li class="nav-header">Maintenance</li>
                            <li class="nav-item dropdown">
                                <a href="<?php echo base_url ?>admin/halls/halls.php" class="nav-link text-light nav-halls">
                                    <i class="nav-icon fas fa-door-closed"></i>
                                    <p>
                                        Hall List
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a href="<?php echo base_url ?>admin/services/services.php"
                                    class="nav-link text-light nav-packages">
                                    <i class="nav-icon fas fa-th-list"></i>
                                    <p>
                                        Services List
                                    </p>
                                </a>
                            </li>
                            
                            <li class="nav-item dropdown">
                                <a href="<?php echo base_url ?>admin/settings/settings.php"
                                    class="nav-link text-light nav-system_info">
                                    <i class="nav-icon fas fa-cogs"></i>
                                    <p>
                                        Settings
                                    </p>
                                </a>
                            </li>

                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
            </div>
        </div>
        <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
                <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
            </div>
        </div>
        <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
                <div class="os-scrollbar-handle" style="height: 55.017%; transform: translate(0px, 0px);"></div>
            </div>
        </div>
        <div class="os-scrollbar-corner"></div>
    </div>
    <!-- /.sidebar -->
</aside>
<script src="<?php echo base_url ?>dist/js/global.js"></script>
