<?php
include('connect.php');
session_start();
if (!isset($_SESSION['s_account_no']) || !isset($_SESSION['s_login'])) {
    header('location:' . app_url('site/dist/auth_login.php'));
    exit;
}
$Account_no = $_SESSION['s_account_no'];
$query_customer = "SELECT full_name FROM tbl_customer WHERE account_no='$Account_no'";
$result_customer = mysqli_query($con, $query_customer);
$row_customer = mysqli_fetch_array($result_customer);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Cheque Book Request</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="assets/images/favicon.ico" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
</head>
<body data-topbar="colored">
    <div id="layout-wrapper">
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between">
                                <h4 class="mb-0">Request Cheque Book</h4>
                                <a href="index.php" class="btn btn-sm btn-primary">Back to Dashboard</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Coming soon</h5>
                                    <p class="text-muted mb-0">
                                        Hi <?php echo htmlspecialchars($row_customer['full_name']); ?>, cheque book requests will be available in a future update.
                                    </p>
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
</body>
</html>