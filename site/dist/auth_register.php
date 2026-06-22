<?php
require_once __DIR__ . '/../../includes/config.php';
require_once __DIR__ . '/../../includes/session.php';
require_once __DIR__ . '/../../includes/csrf.php';
start_secure_session();
?>
<script type="text/javascript">
  function alertifySuccess()
  {
    alertify.alert("Info", "Registration Success", function() {
      window.location = '<?php echo app_url('site/dist/auth_login.php'); ?>';
      alertify.success("Ok");

    });
    return false;
  }
</script>

<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      content="Premium Multipurpose Admin & Dashboard Template"
      name="description"
    />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico" />

   <!-- alertifyjs Css -->
    <link href="assets/libs/alertifyjs/build/css/alertify.min.css" rel="stylesheet" type="text/css" />

    <!-- alertifyjs default themes  Css -->
    <link href="assets/libs/alertifyjs/build/css/themes/default.min.css" rel="stylesheet" type="text/css" />

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
  </head>

  <body class="bg-primary bg-pattern">
    <div class="account-pages pt-4">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <div class="text-center">
              <div clas="row">
                <h5 class="font-size-20 text-white mb-3">
                  <img src="assets/images/favicon.ico" height="24" alt="logo" />
                  DR BANK
                </h5>
              </div>
              <h5 class="font-size-16 text-white-50 mb-3">
                A tradition of trust
              </h5>
            </div>
          </div>
        </div>
        <!-- end row -->

        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Register Here</h4>
                                      
                                        
                                        <form class="needs-validation" method="post" novalidate>
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                <label for="validationTooltip01">First name</label>
                                                <input type="text" name="txt_fname" class="form-control" id="validationTooltip01" placeholder="First name" value="" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                <label for="validationTooltip02">Last name</label>
                                                <input type="text" name="txt_lname" class="form-control" id="validationTooltip02" placeholder="Last name" value="" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                </div>
                                                
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                <h5 class="font-size-14 mb-3">Gender</h5>
                                                    
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" name="txt_gender" value="M" id="custominlineRadio1" name="custominlineRadio" class="custom-control-input" checked>
                                                        <label class="custom-control-label" for="custominlineRadio1">Male</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline">
                                                        <input type="radio" name="txt_gender" value="F" id="custominlineRadio2" name="custominlineRadio" class="custom-control-input">
                                                        <label class="custom-control-label" for="custominlineRadio2">Female</label>
                                                    </div>
                                                </div>
                                            <div class="col-md-4 mb-3">
                                             <div class="form-group mb-4">
                                                <label>Birth Date</label>
                                                <div class="input-group">
                                                    <input type="text" name="txt_bdate" class="form-control" placeholder="mm/dd/yyyy" data-provide="datepicker" data-date-autoclose="true">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                    </div>
                                                </div><!-- input-group -->
                                            </div>
                                            </div>
                                               
                                               
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                <label for="validationTooltip01">Mobile</label>
                                                <input type="text" name="txt_mobile" class="form-control" id="validationTooltip01" placeholder="Mobile" value="" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                <label for="validationTooltip02">Email</label>
                                                <input type="text" name="txt_email" class="form-control" id="validationTooltip02" placeholder="Email Id" value="" required>
                                                <div class="valid-feedback">
                                                    Looks good!
                                                </div>
                                                </div>
                                                
                                            </div>


                                            <div class="row">
                                                <div class="col-md-4 mb-3">
                                                <label for="validationTooltip03">Address</label>
                                                <input type="text" name="txt_address" class="form-control" id="validationTooltip03" placeholder="Address" required>
                                                <div class="invalid-feedback">
                                                    Please provide a valid Address.
                                                </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                <label for="validationTooltip03">City</label>
                                                <input type="text" name="txt_city" class="form-control" id="validationTooltip03" placeholder="City" required>
                                                <div class="invalid-feedback">
                                                    Please provide a valid city.
                                                </div>
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                <label for="validationTooltip04">State</label>
                                                <input type="text" name="txt_state" class="form-control" id="validationTooltip04" placeholder="State" required>
                                                <div class="invalid-feedback">
                                                    Please provide a valid state.
                                                </div>
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                <label for="validationTooltip04">Zip</label>
                                                <input type="text" name="txt_zip" class="form-control" id="validationTooltip04" placeholder="Zip" required>
                                                <div class="invalid-feedback">
                                                    Please provide a valid state.
                                                </div>
                                                </div>
                                            </div>
                                              <div class="row">
                                                <div class="col-md-4 mb-3">
                                                <label for="validationTooltipUsername">Username</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                    <span class="input-group-text" id="validationTooltipUsernamePrepend">@</span>
                                                    </div>
                                                    <input type="text" name="txt_username" class="form-control" id="validationTooltipUsername" placeholder="Username" aria-describedby="validationTooltipUsernamePrepend" required>
                                                    <div class="invalid-feedback">
                                                    Please choose a unique and valid username.
                                                    </div>
                                                </div>
                                                </div>



                                            
                                                <div class="col-md-4 mb-3">
                                                  <label>Password</label>
                                                    <input type="password" name="txt_password" id="pass2" class="form-control" required
                                                            placeholder="Password"/>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                  <label>Confirm Password</label>

                                                    <input type="password" name="txt_repassword" class="form-control" required
                                                            data-parsley-equalto="#pass2"
                                                            placeholder="Re-Type Password"/>
                                                </div>
                                            
                                                
                                          
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                    <label>Account Type</label>
                                                    <select name="txt_account_type" class="custom-select" required>
                                                        <option value="">SELECT ACCOUNT TYPE</option>
                                                        <option value="SAVING">SAVING</option>
                                                        <option value="CURRENT">CURRENT</option>
                                                    </select>
                                                    <div class="invalid-feedback">select account type</div>
                                                </div>
                                            <div class="row">
                                                <div class="custom-control custom-checkbox mt-3 col-md-12 mb-3">
                                                    <input type="checkbox" class="custom-control-input" id="term-conditionCheck" checked>
                                                    <label class="custom-control-label font-weight-normal" for="term-conditionCheck">I accept <a href="#" class="text-primary">Terms and Conditions</a></label>
                                                </div>
                                            </div>
                                            
                                            
                                            
                                            <button class="btn btn-primary" name="btnSubmit" type="submit">Register</button>
                                            <div class="mt-4 text-right">
                                                    <a href="auth_login.php" class="text-muted"><i class="mdi mdi-account-circle mr-1"></i> Already have an Account</a>
                                                </div>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


   
      </div>
    </div>
    <!-- end Account pages -->

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>
    <script src="assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>

            <!-- validation init -->
        <script src="assets/js/pages/form-validation.init.js"></script>

 <!-- alertifyjs js -->
    <script src="assets/libs/alertifyjs/build/alertify.min.js"></script>
    <script src="assets/js/pages/alertifyjs.init.js"></script>

  <!-- Showing Admin ID in alert after switch to Admin login page-->
    <!-- <script>
      $("#add").submit(function() {
  alertify.alert("Alert Title", "Alert Message!", function() {
    alertify.success("Ok");
    window.location = '/auth-login.php';
  });
  return false;
});

    </script> -->
    

    <script src="assets/js/app.js"></script>
  </body>
</html>



<?php

  include('connect.php');
  require_once __DIR__ . '/../../includes/currency.php';

  if(isset($_REQUEST['btnSubmit']))
  {
    require_csrf();

    $first_name = trim($_REQUEST['txt_fname']);
    $last_name = trim($_REQUEST['txt_lname']);
    $full_name = $first_name . ' ' . $last_name;
    $gender = $_REQUEST['txt_gender'];
    $birth_date = date('Y-m-d', strtotime($_REQUEST['txt_bdate']));
    $mobile = trim($_REQUEST['txt_mobile']);
    $email = trim($_REQUEST['txt_email']);
    $address = trim($_REQUEST['txt_address']);
    $city = trim($_REQUEST['txt_city']);
    $state = trim($_REQUEST['txt_state']);
    $zip = (int) $_REQUEST['txt_zip'];
    $username = trim($_REQUEST['txt_username']);
    $password = hash_password($_REQUEST['txt_password']);
    $account_type = $_REQUEST['txt_account_type'];
    $primary_currency = system_primary_currency();

    mysqli_begin_transaction($con);
    try {
        $stmt = $con->prepare('INSERT INTO tbl_account (username, password) VALUES (?, ?)');
        $stmt->bind_param('ss', $username, $password);
        if (!$stmt->execute()) {
            throw new RuntimeException('username_exists');
        }
        $account_no = (int) $con->insert_id;
        $stmt->close();

        $customer_stmt = $con->prepare('INSERT INTO tbl_customer (account_no, full_name, gender, birth_date, mobile, email, primary_currency) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $customer_stmt->bind_param('issssss', $account_no, $full_name, $gender, $birth_date, $mobile, $email, $primary_currency);
        $customer_stmt->execute();
        $customer_stmt->close();

        $address_stmt = $con->prepare('INSERT INTO tbl_address (account_no, home_address, city, state, pincode) VALUES (?, ?, ?, ?, ?)');
        $address_stmt->bind_param('isssi', $account_no, $address, $city, $state, $zip);
        $address_stmt->execute();
        $address_stmt->close();

        $type_stmt = $con->prepare('INSERT INTO tbl_account_type (account_no, account_type) VALUES (?, ?)');
        $type_stmt->bind_param('is', $account_no, $account_type);
        $type_stmt->execute();
        $type_stmt->close();

        $balance = 0;
        $balance_stmt = $con->prepare('INSERT INTO tbl_balance (account_no, account_type, balance) VALUES (?, ?, ?)');
        $balance_stmt->bind_param('isi', $account_no, $account_type, $balance);
        $balance_stmt->execute();
        $balance_stmt->close();

        mysqli_commit($con);
        echo '<script type="text/JavaScript">alertifySuccess();</script>';
    } catch (Throwable $e) {
        mysqli_rollback($con);
        if ($e->getMessage() === 'username_exists') {
            echo '<script type="text/JavaScript">alert("Username already exists.");</script>';
        } else {
            echo '<script type="text/JavaScript">alert("Registration failed. Please try again.");</script>';
        }
    }
  }
?>