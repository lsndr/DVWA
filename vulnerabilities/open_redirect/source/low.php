<?php

// Define an allowlist of approved URLs for redirection
$allowed_urls = [
    'https://trustedsite.com',
    'https://anothertrustedsite.com'
];

if (array_key_exists("redirect", $_GET) && $_GET['redirect'] != "") {
    $redirect_url = $_GET['redirect'];
    
    // Validate the redirect URL against the allowlist
    foreach ($allowed_urls as $allowed_url) {
        if (strpos($redirect_url, $allowed_url) === 0) {
            header("location: " . $redirect_url);
            exit;
        }
    }
    
    // If the URL is not in the allowlist, do not redirect
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