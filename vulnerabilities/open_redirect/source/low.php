<?php

// Define an allowlist of approved paths for redirection
$allowed_paths = [
    '/home',
    '/dashboard',
    '/profile'
];

if (array_key_exists("redirect", $_GET) && $_GET['redirect'] != "") {
    $redirect_path = $_GET['redirect'];
    
    // Ensure the redirect path is relative and in the allowlist
    if (in_array($redirect_path, $allowed_paths)) {
        header("location: " . $redirect_path);
        exit;
    }
    
    // If the path is not in the allowlist, do not redirect
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