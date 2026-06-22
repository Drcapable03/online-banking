<?php
require_once __DIR__ . '/../../includes/config.php';
include('connect.php');

// Only clear session when showing the login form (GET).
// Destroying on POST would invalidate the CSRF token from the form.
if (!isset($_REQUEST['btn_submit'])) {
  if (isset($_SESSION["s_login"]) && isset($_SESSION["s_account_no"])) {
    $logout_time = date("Y-m-d H:i:s");
    $query_for_update_logout = "UPDATE tbl_login_history SET logout_time = '$logout_time' WHERE token_id = (select max(token_id) from tbl_login_history)";
    $result_for_update_logout = mysqli_query($con, $query_for_update_logout) or die('SQL Error :: '.mysqli_error($con));
  }
  session_unset();
  session_destroy();
  start_secure_session();
}

$home_url = app_url('site/dist/index.php');
?>
<script type="text/javascript">
  function wrongAuth()
  {
    Swal.fire({
      title: "Login Failed",
      text: "username or password is incorrect !",
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
    <title>Login</title>
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
            <a href="<?php echo app_url('admin/dist/auth-login.php'); ?>"><i class="mdi mdi-home-variant h2 text-white"></i></a>
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
                          <label for="id">Username</label>
                          <input
                            type="text"
                            class="form-control"
                            id="adminId"
                            name='txt_username'
                            placeholder="Your Username"
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
                          <a href="auth_register.php" class="text-muted"
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

    $username = trim($_REQUEST["txt_username"]);
    $password = $_REQUEST["txt_password"];

    $wait = check_login_rate_limit('customer', $username);
    if ($wait !== null) {
        echo '<script type="text/JavaScript">Swal.fire({title:"Too many attempts",text:"Please wait ' . (int) $wait . ' seconds before trying again.",icon:"warning"});</script>';
        exit;
    }

    $stmt = $con->prepare('SELECT account_no, password FROM tbl_account WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result1 = $stmt->get_result();
    if($row = $result1->fetch_assoc())
    {
        if (verify_password($row['password'], $password))
        {
            $account_no = (int) $row['account_no'];
            if (!password_get_info($row['password'])['algo']) {
                upgrade_account_password($con, $account_no, $password);
            }
            regenerate_session();
            $_SESSION["_csrf_token"] = bin2hex(random_bytes(32));
            $_SESSION["s_account_no"] = $account_no;
            $_SESSION["s_login"] = date("Y-m-d H:i:s");
            $Login_time = $_SESSION["s_login"];
            $history_stmt = $con->prepare('INSERT INTO tbl_login_history (account_no, login_time) VALUES (?, ?)');
            $history_stmt->bind_param('is', $account_no, $Login_time);
            $history_stmt->execute();
            $history_stmt->close();
            clear_login_failures('customer', $username);
            echo '<script type="text/JavaScript">rightAuth();</script>';
        }
        else
        {
            record_login_failure('customer', $username);
            echo '<script type="text/JavaScript">wrongAuth();</script>';
        }
    }
    else
    {
        record_login_failure('customer', $username);
        echo '<script type="text/JavaScript">wrongAuth();</script>';
    }
    $stmt->close();
}
?>