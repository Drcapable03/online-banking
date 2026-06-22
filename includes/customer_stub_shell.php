<?php

if (!isset($row_customer) || !is_array($row_customer)) {
    header('location:' . app_url('site/dist/auth_login.php'));
    exit;
}

$page_title = $page_title ?? 'DR BANK';
$page_heading = $page_heading ?? $page_title;
$stub_message = $stub_message ?? 'This feature is coming in a future update.';
$stub_phase = $stub_phase ?? 'Phase 2';
$customer_nav_section = $customer_nav_section ?? 'accounts';
$customer_nav_page = $customer_nav_page ?? '';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/customer-nav.css" rel="stylesheet" type="text/css" />
</head>
<body data-topbar="dark" data-layout="horizontal">
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <div class="navbar-brand-box">
                        <a href="index.php" class="logo logo-dark">
                            <span class="logo-sm"><img src="assets/images/logo-sm-dark.png" alt="" height="22"></span>
                            <span class="logo-lg"><img src="assets/images/logo-dark.png" alt="" height="19"></span>
                        </a>
                        <a href="index.php" class="logo logo-light">
                            <span class="logo-sm"><img src="assets/images/logo-sm-light.png" alt="" height="22"></span>
                            <span class="logo-lg"><img src="assets/images/logo-light.png" alt="" height="19"></span>
                        </a>
                    </div>
                    <button type="button" class="btn btn-sm mr-2 font-size-16 d-lg-none header-item waves-effect waves-light" data-toggle="collapse" data-target="#topnav-menu-content">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>
                </div>
                <div class="d-flex">
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg" alt="Header Avatar">
                            <span class="d-none d-sm-inline-block ml-1"><?php echo htmlspecialchars($row_customer['full_name']); ?></span>
                            <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a class="dropdown-item" href="profile.php"><i class="mdi mdi-face-profile font-size-16 align-middle mr-1"></i> Profile</a>
                            <a class="dropdown-item" href="security_center.php"><i class="mdi mdi-shield-check-outline font-size-16 align-middle mr-1"></i> Security</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo app_url('site/dist/auth_login.php'); ?>"><i class="mdi mdi-logout font-size-16 align-middle mr-1"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <?php require __DIR__ . '/customer_nav.php'; ?>
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0 font-size-18"><?php echo htmlspecialchars($page_heading); ?></h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                        <li class="breadcrumb-item active"><?php echo htmlspecialchars($page_heading); ?></li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <span class="badge badge-soft-primary mb-3"><?php echo htmlspecialchars($stub_phase); ?></span>
                                    <h5 class="card-title">Coming Soon</h5>
                                    <p class="text-muted mb-3"><?php echo htmlspecialchars($stub_message); ?></p>
                                    <p class="text-muted mb-0">Hi <?php echo htmlspecialchars($row_customer['full_name']); ?>, this section is part of our Accounts hub rollout. Your existing transfers, requests, and profile features are unchanged.</p>
                                    <div class="mt-4">
                                        <a href="index.php" class="btn btn-primary mr-2">Back to Dashboard</a>
                                        <a href="profile.php" class="btn btn-outline-secondary">Account Information</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>
</html>