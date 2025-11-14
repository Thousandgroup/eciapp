<nav class="main-header navbar navbar-expand navbar-white navbar-light bg-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#">
                <i class="fas fa-user"></i>
                <span class="ml-2 d-none d-lg-inline text-gray-600 text-sm"><?= $this->session->userdata('name') ? $this->session->userdata('name') : 'Guest'; ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">Setting Account</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-user mr-2"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-cog mr-2"></i> Change Password
                </a>
                <div class="dropdown-divider"></div>
                <a href="<?=site_url('logout'); ?>" class="dropdown-item">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
                <div class="dropdown-divider"></div>
            </div>
        </li>
    </ul>
</nav>