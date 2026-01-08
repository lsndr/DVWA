<?php

// Define a fixed set of internal pages for redirection
$allowed_pages = [
    'home' => '/home.php',
    'dashboard' => '/dashboard.php',
    'profile' => '/profile.php'
];

if (array_key_exists("redirect", $_GET) && $_GET['redirect'] != "") {
    $redirect_key = $_GET['redirect'];
    
    // Use a fixed mapping to internal pages only
    if (array_key_exists($redirect_key, $allowed_pages)) {
        header("location: " . $allowed_pages[$redirect_key]);
        exit;
    }
    
    // If the key is not in the allowed list, do not redirect
    http_response_code(400);
    echo "Invalid redirect target.";
    exit;
}

http_response_code(500);
?>
<p>Missing redirect target.</p>
<?php
exit;
?>