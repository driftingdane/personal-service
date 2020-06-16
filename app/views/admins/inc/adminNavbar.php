<!-- Side Navbar -->
<section>
<nav class="side-navbar">
    <div class="side-navbar-wrapper">
        <!-- Sidebar Header    -->
        <div class="sidenav-header d-flex align-items-center justify-content-center">
            <!-- User Info-->
            <div class="sidenav-header-inner text-center">
                <img src="<?php echo URLROOT . '/all_img/img/' . userAvatar(); ?>" alt="person" class="img-fluid rounded-circle">
                <h2 class="h5"><?php echo $_SESSION['user_name']; ?></h2><span class="userPosition text-capitalize"><small><?php echo str_replace("is_", "", $_SESSION['has_access']); ?></small></span>
            </div>
            <!-- Small Brand information, appears on minimized sidebar-->
            <div class="sidenav-header-logo"><a href="<?php echo URLROOT; ?>" class="brand-small text-center">
                    <?php
                    if(empty($data['siteImg'])) { $setImg = "nologo.png"; } else { $setImg = $data['siteImg']; } ?>
                    <img class="" width="50" alt="Logo" src="<?php echo URLROOT . '/all_img/img/' . $setImg; ?>">
                </a>
            </div>
        </div>
        <!-- Sidebar Navigation Menus-->
            <div class="main-menu">
                <ul id="side-main-menu" class="side-menu list-unstyled text-capitalize">
                    <?php
                    // Get access links based on user access
                    checkAccessSideLinks(); ?>
                </ul>
            </div>
        </div>

    </div>
</nav>

    <div class="page">
    <!-- navbar-->
    <header class="header">
        <nav class="navbar admin border-bottom shadow-sm">
            <div class="container-fluid">
                <div class="navbar-holder d-flex align-items-center justify-content-between">
                    <div class="navbar-header"><a id="toggle-btn" href="#" class="menu-btn"><i class="fas fa-bars"></i></a><a href="<?php echo URLROOT; ?>" class="navbar-brand">
                            <div class="brand-text d-none d-md-inline-block"><span>Admin</span><strong class="text-primary">Dashboard</strong></div></a></div>
                    <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">

                        <div class="btn-group btn-group-sm">
                            <?php if (isLoggedIn()) : ?>
                                <div class="dropdown mr-2">
                                    <button class="btn btn-sm btn-outline-info dropdown-toggle" type="button" id="dropdownMenu2"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="far fa-user"></i> Profile <span class="caret"></span>
                                    </button>
                                    <?php
                                    if($_SESSION['has_access'] === 'is_admin') : ?>
                                    <a href="<?php echo URLROOT; ?>/admins" class="btn btn-sm btn-outline-info mt-2 mb-2"><i class="fas fa-user-shield"></i> Admins</a>
                                    <?php else: ?>
                                        <a href="<?php echo URLROOT; ?>/clients" class="btn btn-sm btn-outline-info mt-2 mb-2"><i class="fas fa-graduation-cap"></i> Clients</a>
                                    <?php endif; ?>
                                    <div class="dropdown-menu dropdown-menu" aria-labelledby="dropdownMenu2">
                                        <?php require APPROOT . '/views/admins/inc/appButtons.php'; ?>
                                    </div>
                                </div>

                            <?php else : ?>
                                <a href="<?php echo URLROOT; ?>/users/login" class="btn btn-outline-info mr-2"><i
                                            class="fas fa-sign-in-alt"></i> Login</a>
                                <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-outline-info"><i
                                            class="fas fa-user-plus"></i> Register</a>
                            <?php endif; ?>
                        </div>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    </div>
</section>

