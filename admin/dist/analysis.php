<?php
include('connect.php');
session_start();
if (!isset($_SESSION['s_admin_id'])) {
    header('location:' . app_url('admin/dist/auth-login.php'));
    exit;
}
$Admin_id = $_SESSION['s_admin_id'];
$query_admin = "SELECT full_name FROM tbl_admin WHERE admin_id=$Admin_id";
$result_admin = mysqli_query($con, $query_admin);
$row_admin_detail = mysqli_fetch_array($result_admin);

$customer_count = mysqli_fetch_assoc(mysqli_query($con, 'SELECT COUNT(*) AS count FROM tbl_customer'))['count'];
$transaction_count = mysqli_fetch_assoc(mysqli_query($con, 'SELECT COUNT(*) AS count FROM tbl_transaction'))['count'];
$total_balance = mysqli_fetch_assoc(mysqli_query($con, 'SELECT SUM(balance) AS total FROM tbl_balance'))['total'] ?? 0;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Analysis</title>
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
                                <h4 class="mb-0">Bank Analysis</h4>
                                <a href="index.php" class="btn btn-sm btn-primary">Back to Dashboard</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-muted mb-1">Customers</p>
                                    <h4><?php echo (int) $customer_count; ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-muted mb-1">Transactions</p>
                                    <h4><?php echo (int) $transaction_count; ?></h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-muted mb-1">Total Balance</p>
                                    <h4><?php echo number_format((float) $total_balance, 2); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-muted mb-0">
                                        Welcome <?php echo htmlspecialchars($row_admin_detail['full_name']); ?>. Advanced charts and reporting will be added in a future update.
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