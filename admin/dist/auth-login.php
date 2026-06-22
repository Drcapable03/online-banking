<?php
require_once __DIR__ . '/../../includes/config.php';
include('connect.php');
session_unset();
session_destroy();
start_secure_session();

$home_url = app_url('admin/dist/index.php');
?>
<script type="text/javascript">
  function wrongAuth()
  {
    Swal.fire({
      title: "Login Failed",
      text: "Admin Id or password is incorrect !",
      icon: "error"
    });
  }
  function rightAuth()
  {
    location.replace("<?php echo $home_url; ?>");
  }

</script>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      content="Premium Multipurpose Admin & Dashboard Template"
      name="description"
    />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />

    <!-- Bootstrap Css -->
    <link
      href="assets/css/bootstrap.min.css"
      rel="stylesheet"
      type="text/css"
    />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
     <!-- Sweet Alert-->
    <link href="assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
  </head>

  <body class="bg-primary bg-pattern">
    <div class="home-btn d-none d-sm-block">
            <a href="<?php echo app_url('site/dist/auth_login.php'); ?>"><i class="mdi mdi-home-variant h2 text-white"></i></a>
        </div>
    <div class="account-pages my-5 pt-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="text-center mb-5">
              <div clas="row">
                <h5 class="font-size-20 text-white mb-4">
                  <img src="assets/images/favicon.ico" height="24" alt="logo" />
                  DR BANK
                </h5>
              </div>
              <h5 class="font-size-25 text-white mb-4">Only use for Admin</h5>
              <h5 class="font-size-16 text-white-50 mb-4">
                A tradition of trust
              </h5>
            </div>
          </div>
        </div>
        <!-- end row -->

        <div class="row justify-content-center">
          <div class="col-lg-5">
            <div class="card">
              <div class="card-body p-4">
                <div class="p-2">
                  <h5 class="mb-5 text-center">
                    Sign in to continue to DR BANK.
                  </h5>
                  <form class="form-horizontal" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group mb-4">
                          <label for="id">Admin ID</label>
                          <input
                            type="text"
                            class="form-control"
                            id="adminId"
                            name='txt_adminid'
                            placeholder="Enter admin Id"
                            value=""
                            required

                          />
                        </div>
                        <div class="form-group mb-4">
                          <label for="userpassword">Password</label>
                          <input
                            type="password"
                            class="form-control"
                            id="userpassword"
                            name="txt_password"
                            placeholder="Enter password"
                            required
                          />
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="custom-control custom-checkbox">
                              <input
                                type="checkbox"
                                class="custom-control-input"
                                id="customControlInline"
                                
                              />
                              <label
                                class="custom-control-label"
                                for="customControlInline"
                                >Remember me</label
                              >
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="text-md-right mt-3 mt-md-0">
                              <a href="auth_recoverpw.php" class="text-muted"
                                ><i class="mdi mdi-lock"></i> Forgot your
                                password?</a
                              >
                            </div>
                          </div>
                        </div>
                        <div class="mt-4">
                          <button
                            class="btn btn-success btn-block waves-effect waves-light"
                            type="submit"
                            name="btn_submit"
                          >
                            Log In
                          </button>
                        </div>
                        <div class="mt-4 text-center">
                          <a href="auth-register.php" class="text-muted"
                            ><i class="mdi mdi-account-circle mr-1"></i> Create
                            an account</a
                          >
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end row -->
      </div>
    </div>
    <!-- end Account pages -->

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <!-- Sweet Alerts js -->
      <script src="assets/libs/sweetalert2/sweetalert2.min.js"></script>
      <!-- Sweet alert init js-->
      <script src="assets/js/pages/sweet-alerts.init.js"></script>

    <script src="assets/js/app.js"></script>
  </body>
</html>

<?php

  if(isset($_REQUEST['btn_submit']))
  {
    require_csrf();
    require_once __DIR__ . '/../../includes/rate_limit.php';

    $Admin_id = (int) $_REQUEST["txt_adminid"];
    $Password = $_REQUEST["txt_password"];
    $rate_key = (string) $Admin_id;

    $wait = check_login_rate_limit('admin', $rate_key);
    if ($wait !== null) {
        echo '<script type="text/JavaScript">Swal.fire({title:"Too many attempts",text:"Please wait ' . (int) $wait . ' seconds before trying again.",icon:"warning"});</script>';
        exit;
    }

    $stmt = $con->prepare('SELECT admin_id, password FROM tbl_admin WHERE admin_id = ?');
    $stmt->bind_param('i', $Admin_id);
    $stmt->execute();
    $result1 = $stmt->get_result();

    if($row = $result1->fetch_assoc())
    {
      if (verify_password($row['password'], $Password))
      {
        if (!password_get_info($row['password'])['algo']) {
          upgrade_admin_password($con, $Admin_id, $Password);
        }
        clear_login_failures('admin', $rate_key);
        regenerate_session();
        $_SESSION['s_admin_id'] = $Admin_id;
        header("location:" . app_url('admin/dist/index.php'));
        echo '<script type="text/JavaScript">rightAuth();</script>';
      }
      else
      {
        record_login_failure('admin', $rate_key);
        echo '<script type="text/JavaScript">wrongAuth();</script>';
      }
    }
    else
    {
      record_login_failure('admin', $rate_key);
      echo '<script type="text/JavaScript">wrongAuth();</script>';
    }
    $stmt->close();
  }
?>