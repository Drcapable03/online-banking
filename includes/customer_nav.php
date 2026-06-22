<?php

if (!function_exists('customer_nav_item_class')) {
    function customer_nav_item_class(string $page, ?string $active_page = null): string
    {
        return ($active_page === $page) ? 'dropdown-item active' : 'dropdown-item';
    }

    function customer_nav_section_class(string $section, ?string $active_section = null): string
    {
        return ($active_section === $section) ? 'nav-link dropdown-toggle arrow-none active' : 'nav-link dropdown-toggle arrow-none';
    }

    function customer_nav_top_class(string $section, ?string $active_section = null): string
    {
        return ($active_section === $section) ? 'nav-link active' : 'nav-link';
    }
}

$customer_nav_section = $customer_nav_section ?? '';
$customer_nav_page = $customer_nav_page ?? '';
?>
<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">
            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="<?php echo customer_nav_section_class('accounts', $customer_nav_section); ?>" href="#" id="topnav-accounts" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-bank mr-2"></i>Accounts <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu customer-mega-menu p-3" aria-labelledby="topnav-accounts">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h6 class="dropdown-header text-uppercase">Account Management</h6>
                                    <a class="<?php echo customer_nav_item_class('profile', $customer_nav_page); ?>" href="profile.php"><i class="mdi mdi-account-card-details-outline mr-2"></i>Account Information</a>
                                    <a class="<?php echo customer_nav_item_class('statements', $customer_nav_page); ?>" href="statements.php"><i class="mdi mdi-file-document-outline mr-2"></i>Statements &amp; Documents</a>
                                    <a class="<?php echo customer_nav_item_class('alerts', $customer_nav_page); ?>" href="account_alerts.php"><i class="mdi mdi-bell-outline mr-2"></i>Account Alerts</a>
                                    <a class="<?php echo customer_nav_item_class('routing', $customer_nav_page); ?>" href="routing_numbers.php"><i class="mdi mdi-pound mr-2"></i>Routing Numbers</a>
                                    <a class="<?php echo customer_nav_item_class('order_checks', $customer_nav_page); ?>" href="cheque_book.php"><i class="mdi mdi-book-open-page-variant mr-2"></i>Order Checks or Currency</a>
                                    <a class="<?php echo customer_nav_item_class('spending', $customer_nav_page); ?>" href="spending_budgeting.php"><i class="mdi mdi-chart-pie mr-2"></i>Spending &amp; Budgeting</a>
                                </div>
                                <div class="col-lg-6 border-left">
                                    <h6 class="dropdown-header text-uppercase">Security &amp; Settings</h6>
                                    <a class="<?php echo customer_nav_item_class('cards', $customer_nav_page); ?>" href="card_management.php"><i class="mdi mdi-credit-card-outline mr-2"></i>Card Management</a>
                                    <a class="<?php echo customer_nav_item_class('security', $customer_nav_page); ?>" href="security_center.php"><i class="mdi mdi-shield-check-outline mr-2"></i>Security Center</a>
                                    <a class="<?php echo customer_nav_item_class('authorized', $customer_nav_page); ?>" href="authorized_users.php"><i class="mdi mdi-account-multiple-outline mr-2"></i>Authorized Users</a>
                                    <a class="<?php echo customer_nav_item_class('overdraft', $customer_nav_page); ?>" href="overdraft.php"><i class="mdi mdi-shield-link-variant mr-2"></i>Overdraft Protection</a>
                                    <a class="<?php echo customer_nav_item_class('rewards', $customer_nav_page); ?>" href="rewards.php"><i class="mdi mdi-star-outline mr-2"></i>Rewards &amp; Deals</a>
                                    <a class="<?php echo customer_nav_item_class('customize', $customer_nav_page); ?>" href="customize_accounts.php"><i class="mdi mdi-tune mr-2"></i>Customize My Accounts</a>
                                    <a class="<?php echo customer_nav_item_class('add_account', $customer_nav_page); ?>" href="add_account.php"><i class="mdi mdi-plus-circle-outline mr-2"></i>Add an Account</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="<?php echo customer_nav_section_class('pay', $customer_nav_section); ?>" href="#" id="topnav-pay" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-bank-transfer mr-2"></i>Pay &amp; Transfer <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-pay">
                            <a class="<?php echo customer_nav_item_class('transactions', $customer_nav_page); ?>" href="index.php"><i class="mdi mdi-format-list-bulleted mr-2"></i>Transaction History</a>
                            <a class="<?php echo customer_nav_item_class('quick_transfer', $customer_nav_page); ?>" href="quick_transfer.php"><i class="mdi mdi-swap-horizontal mr-2"></i>Quick Transfer</a>
                            <a class="<?php echo customer_nav_item_class('request_money', $customer_nav_page); ?>" href="inbox.php"><i class="mdi mdi-email-send-outline mr-2"></i>Request Money</a>
                            <a class="<?php echo customer_nav_item_class('send_requests', $customer_nav_page); ?>" href="send_requests.php"><i class="mdi mdi-send-check-outline mr-2"></i>Send Requests</a>
                            <a class="<?php echo customer_nav_item_class('new_request', $customer_nav_page); ?>" href="request_money.php"><i class="mdi mdi-plus-circle-outline mr-2"></i>New Request</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="<?php echo customer_nav_top_class('security', $customer_nav_section); ?>" href="security_center.php">
                            <i class="mdi mdi-shield-check-outline mr-2"></i>Security
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="<?php echo customer_nav_section_class('help', $customer_nav_section); ?>" href="#" id="topnav-help" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-help-circle-outline mr-2"></i>Help <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-help">
                            <a class="<?php echo customer_nav_item_class('faqs', $customer_nav_page); ?>" href="FAQs.php"><i class="mdi mdi-book-open-variant mr-2"></i>FAQs</a>
                            <a class="<?php echo customer_nav_item_class('feedback', $customer_nav_page); ?>" href="feedback.php"><i class="mdi mdi-heart-outline mr-2"></i>Feedback</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>