$root = Split-Path -Parent $PSScriptRoot
$phpDir = Join-Path $root 'site\src\php'

$navConfig = @{
    'index.php' = @{ section = 'pay'; page = 'transactions' }
    'quick_transfer.php' = @{ section = 'pay'; page = 'quick_transfer' }
    'inbox.php' = @{ section = 'pay'; page = 'request_money' }
    'inbox_read.php' = @{ section = 'pay'; page = 'request_money' }
    'send_requests.php' = @{ section = 'pay'; page = 'send_requests' }
    'send_requests_read.php' = @{ section = 'pay'; page = 'send_requests' }
    'request_money.php' = @{ section = 'pay'; page = 'new_request' }
    'profile.php' = @{ section = 'accounts'; page = 'profile' }
    'feedback.php' = @{ section = 'help'; page = 'feedback' }
    'FAQs.php' = @{ section = 'help'; page = 'faqs' }
}

$navPattern = '(?s)\r?\n\s*<div class="topnav">.*?</div>\s*</div>\s*</div>'

foreach ($file in $navConfig.Keys) {
    $path = Join-Path $phpDir $file
    if (-not (Test-Path $path)) {
        Write-Warning "Missing $file"
        continue
    }

    $content = Get-Content -Path $path -Raw -Encoding UTF8
    $cfg = $navConfig[$file]
    $replacement = @"

            <?php
                `$customer_nav_section = '$($cfg.section)';
                `$customer_nav_page = '$($cfg.page)';
                require __DIR__ . '/../../includes/customer_nav.php';
            ?>
"@

    $newContent = [regex]::Replace($content, $navPattern, $replacement, 1)
    if ($newContent -eq $content) {
        Write-Warning "Nav block not replaced in $file"
        continue
    }

    if ($newContent -notmatch 'customer-nav\.css') {
        $newContent = $newContent -replace '(<link href="assets/css/app\.min\.css" rel="stylesheet" type="text/css" />)', "`$1`r`n        <link href=`"assets/css/customer-nav.css`" rel=`"stylesheet`" type=`"text/css`" />"
    }

    $newContent = $newContent -replace '<a class="dropdown-item" href="#"><i class="mdi mdi-face-profile font-size-16 align-middle mr-1"></i> Profile</a>', '<a class="dropdown-item" href="profile.php"><i class="mdi mdi-face-profile font-size-16 align-middle mr-1"></i> Profile</a>'
    $logoutHref = "<?php echo app_url('site/dist/auth_login.php'); ?>"
    $logoutReplacement = '<a class="dropdown-item" href="' + $logoutHref + '"><i class="mdi mdi-logout'
    $newContent = $newContent -replace '<a class="dropdown-item" href="auth_login\.php"><i class="mdi mdi-logout', $logoutReplacement

    $utf8NoBom = New-Object System.Text.UTF8Encoding $false
    [System.IO.File]::WriteAllText($path, $newContent, $utf8NoBom)
    Write-Host "Updated $file"
}